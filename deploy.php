<?php

namespace Deployer;

require 'recipe/symfony.php';

// ---------------------------------------------------------------------------
// Config
// ---------------------------------------------------------------------------

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Where database dumps are stored remotely and locally.
set('database_dump_remote_dir', '{{deploy_path}}/shared/db-dumps');
set('database_dump_local_dir', 'var/db-dumps');

// ---------------------------------------------------------------------------
// Hosts
// ---------------------------------------------------------------------------

try {
    if (file_exists('.hosts.yaml')) {
        import('.hosts.yaml');
    }
} catch (Exception\Exception $e) {
    // .hosts.yaml is optional for local-only usage.
}

// ---------------------------------------------------------------------------
// Helper functions
// ---------------------------------------------------------------------------

/**
 * Parse a .env file into an associative array.
 * Skips comments and empty lines, strips surrounding quotes.
 */
function parseEnvFileContent(string $content): array
{
    $values = [];

    foreach (preg_split('/\R/', $content) ?: [] as $line) {
        $trimmed = trim($line);

        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            continue;
        }

        if (!preg_match('/^(?:export\s+)?([A-Z0-9_]+)=(.*)$/', $trimmed, $matches)) {
            continue;
        }

        $key = $matches[1];
        $value = trim($matches[2]);

        // Strip surrounding quotes.
        if ($value !== '' && (
            (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))
        )) {
            $value = substr($value, 1, -1);
        }

        $values[$key] = stripcslashes($value);
    }

    return $values;
}

/**
 * Extract host, port, database, user and password from a DATABASE_URL.
 */
function parseDatabaseUrl(string $databaseUrl): array
{
    $parts = parse_url($databaseUrl);

    if ($parts === false || !isset($parts['path'])) {
        throw new \RuntimeException('Invalid DATABASE_URL format.');
    }

    $databaseName = ltrim((string) $parts['path'], '/');

    if ($databaseName === '') {
        throw new \RuntimeException('DATABASE_URL does not include a database name.');
    }

    return [
        'db_host' => (string) ($parts['host'] ?? '127.0.0.1'),
        'db_port' => (string) ($parts['port'] ?? 3306),
        'db_name' => urldecode($databaseName),
        'db_user' => urldecode((string) ($parts['user'] ?? '')),
        'db_password' => urldecode((string) ($parts['pass'] ?? '')),
    ];
}

/**
 * Replace ${VAR}, ${VAR:-default} and $VAR placeholders with values
 * from the given array.
 */
function resolveEnvPlaceholders(string $value, array $variables): string
{
    $resolved = preg_replace_callback(
        '/\$\{([A-Z0-9_]+)(:-([^}]*))?\}/',
        static function (array $matches) use ($variables): string {
            $name = $matches[1];
            $default = $matches[3] ?? '';
            $current = $variables[$name] ?? null;

            return ($current !== null && $current !== '') ? (string) $current : $default;
        },
        $value
    );

    if (!is_string($resolved)) {
        $resolved = $value;
    }

    $resolved = preg_replace_callback(
        '/\$([A-Z0-9_]+)/',
        static fn(array $matches): string => (string) ($variables[$matches[1]] ?? $matches[0]),
        $resolved
    );

    return is_string($resolved) ? $resolved : $value;
}

/**
 * Run a Symfony console command locally, respecting DDEV context.
 */
function runLocalConsole(bool $insideDdev, string $arguments): void
{
    $prefix = $insideDdev ? '' : 'ddev exec ';
    runLocally($prefix . 'php bin/console ' . $arguments);
}

/**
 * Run doctrine:migrations:migrate locally and capture both output and exit
 * code without letting Deployer abort on a non-zero exit.
 */
function runLocalMigrationCommand(bool $insideDdev): array
{
    $prefix = $insideDdev ? '' : 'ddev exec ';
    $command = 'set +e; php bin/console doctrine:migrations:migrate -n --allow-no-migration 2>&1;'
        . ' status=$?; printf "\\n__EXIT_CODE__:%s" "$status"; exit 0';

    $output = runLocally($prefix . 'bash -lc ' . escapeshellarg($command));

    $exitCode = 1;
    if (preg_match('/__EXIT_CODE__:(\d+)\s*$/', $output, $matches)) {
        $exitCode = (int) $matches[1];
        $output = preg_replace('/__EXIT_CODE__:\d+\s*$/', '', $output) ?? $output;
    }

    return [$exitCode, trim($output)];
}

/**
 * Mark a single migration version as executed locally.
 * Silently ignores the case where the version is already registered.
 */
function markMigrationAsExecutedLocal(bool $insideDdev, string $version): void
{
    try {
        runLocalConsole($insideDdev, 'doctrine:migrations:version ' . escapeshellarg($version) . ' --add --no-interaction');
    } catch (\Throwable $exception) {
        if (!str_contains($exception->getMessage(), 'already exists in the version table')) {
            throw $exception;
        }
    }
}

/**
 * Migrate the local database to the current code state.
 *
 * When a migration fails because the schema change already exists in the
 * imported dump (e.g. live DB was updated before migration metadata was
 * recorded), the failing version is marked as executed and the migration
 * is retried automatically (up to 5 times).
 */
function migrateLocalDatabase(bool $insideDdev): void
{
    runLocalConsole($insideDdev, 'doctrine:migrations:sync-metadata-storage --no-interaction');

    $maxRetries = 5;

    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        [$exitCode, $output] = runLocalMigrationCommand($insideDdev);

        if ($exitCode === 0) {
            return;
        }

        if (!preg_match('/Migration\s+([^\s]+)\s+failed during Execution\./i', $output, $matches)) {
            throw new \RuntimeException('Local migration failed: ' . $output);
        }

        $version = (string) $matches[1];

        if (!str_starts_with($version, 'DoctrineMigrations\\')) {
            throw new \RuntimeException('Local migration failed: ' . $output);
        }

        writeln(sprintf('<comment>Marking %s as executed and retrying (%d/%d).</comment>', $version, $attempt, $maxRetries));
        markMigrationAsExecutedLocal($insideDdev, $version);
    }

    throw new \RuntimeException('Failed to migrate local database after ' . $maxRetries . ' retries.');
}

/**
 * Resolve database credentials from remote env files.
 *
 * Reads DATABASE_URL (preferred) or DB_NAME/DB_USER/DB_PASSWORD from the
 * first matching env file on the remote host:
 *   shared/.env.local > shared/.env.prod.local > current/.env.local
 *   > current/.env.prod.local > current/.env
 */
function resolveDatabaseConfig(): array
{
    $envValues = [];
    $envSource = '';
    $deployPath = rtrim((string) get('deploy_path'), '/');
    $envFiles = [
        $deployPath . '/shared/.env.local',
        $deployPath . '/shared/.env.prod.local',
        $deployPath . '/current/.env.local',
        $deployPath . '/current/.env.prod.local',
        $deployPath . '/current/.env',
    ];

    foreach ($envFiles as $envFile) {
        $content = run(sprintf('[ -f %s ] && cat %s || true', escapeshellarg($envFile), escapeshellarg($envFile)));

        if (trim($content) === '') {
            continue;
        }

        foreach (parseEnvFileContent($content) as $key => $value) {
            if (!array_key_exists($key, $envValues)) {
                $envValues[$key] = $value;

                if ($key === 'DATABASE_URL') {
                    $envSource = $envFile;
                }
            }
        }
    }

    if (isset($envValues['DATABASE_URL']) && $envValues['DATABASE_URL'] !== '') {
        $databaseUrl = resolveEnvPlaceholders((string) $envValues['DATABASE_URL'], $envValues);
        writeln(sprintf('<comment>Resolved DB config from: %s</comment>', $envSource ?: 'remote env'));

        return parseDatabaseUrl($databaseUrl);
    }

    throw new \RuntimeException(
        'Could not resolve database credentials. No DATABASE_URL found in remote env files.'
    );
}

// ---------------------------------------------------------------------------
// Tasks
// ---------------------------------------------------------------------------

desc('Create and download a remote database dump');
task('database:dump:pull', function () {
    $dbConfig = resolveDatabaseConfig();

    foreach (['db_name', 'db_user', 'db_password'] as $required) {
        if (!isset($dbConfig[$required]) || $dbConfig[$required] === '') {
            throw new \RuntimeException(sprintf('Database setting "%s" is empty.', $required));
        }
    }

    $dbHost = (string) ($dbConfig['db_host'] ?? '127.0.0.1');
    $dbPort = (string) ($dbConfig['db_port'] ?? '3306');
    $dbName = (string) $dbConfig['db_name'];
    $dbUser = (string) $dbConfig['db_user'];
    $dbPassword = (string) $dbConfig['db_password'];

    writeln(sprintf('<comment>Dumping "%s" from %s:%s as "%s"</comment>', $dbName, $dbHost, $dbPort, $dbUser));

    $fileName = sprintf('db-%s-%s.sql.gz', date('Ymd_His'), substr(md5((string) microtime(true)), 0, 6));
    $remoteFile = rtrim((string) get('database_dump_remote_dir'), '/') . '/' . $fileName;
    $localDir = rtrim((string) get('database_dump_local_dir'), '/');
    $localFile = $localDir . '/' . $fileName;

    // Dump on remote and compress.
    run('mkdir -p {{database_dump_remote_dir}}');
    run(sprintf(
        'set -o pipefail && mysqldump --single-transaction --quick --lock-tables=false'
        . ' --no-tablespaces --default-character-set=utf8mb4'
        . ' -h %s -P %s -u %s -p%s %s | gzip -9 > %s',
        escapeshellarg($dbHost),
        escapeshellarg($dbPort),
        escapeshellarg($dbUser),
        escapeshellarg($dbPassword),
        escapeshellarg($dbName),
        escapeshellarg($remoteFile)
    ));

    // Verify the dump is not empty.
    run(sprintf('test -s %s', escapeshellarg($remoteFile)));

    // Download to local machine.
    runLocally(sprintf('mkdir -p %s', escapeshellarg($localDir)));
    download($remoteFile, $localFile);

    set('database_dump_last_local_file', $localFile);
    writeln(sprintf('<info>Database dump downloaded: %s</info>', $localFile));
});

desc('Import the latest pulled dump into DDEV');
task('database:import:ddev', function () {
    // Prefer the dump from this session, fall back to newest local file.
    if (has('database_dump_last_local_file')) {
        $localFile = (string) get('database_dump_last_local_file');
    } else {
        $dumpFiles = glob(rtrim((string) get('database_dump_local_dir'), '/') . '/*.sql.gz') ?: [];
        usort($dumpFiles, static fn(string $a, string $b): int => filemtime($b) <=> filemtime($a));
        $localFile = $dumpFiles[0] ?? '';
    }

    if ($localFile === '') {
        throw new \RuntimeException('No local dump file found. Run "dep database:pull" first.');
    }

    $insideDdev = (string) getenv('IS_DDEV_PROJECT') === 'true';

    // Import the SQL dump.
    if ($insideDdev) {
        runLocally(sprintf('set -o pipefail && gzip -dc %s | mysql -h db -u db -pdb db', escapeshellarg($localFile)));
    } else {
        runLocally(sprintf('ddev import-db --file=%s', escapeshellarg($localFile)));
    }

    // Migrate to match the local code state.
    migrateLocalDatabase($insideDdev);
    runLocalConsole($insideDdev, 'cache:clear --no-warmup');
});

desc('Pull remote database and import into DDEV');
task('database:pull', [
    'database:dump:pull',
    'database:import:ddev',
]);

// ---------------------------------------------------------------------------
// Deploy hooks
// ---------------------------------------------------------------------------

desc('Run database migrations on remote');
task('database:migrate', function () {
    run('{{bin/console}} doctrine:migrations:migrate --no-interaction --allow-no-migration');
});

after('deploy:vendors', 'database:migrate');
after('deploy:failed', 'deploy:unlock');
