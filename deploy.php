<?php

namespace Deployer;

require 'recipe/symfony.php';

// Config

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
try {
    // load local hosts file if exists
    if (file_exists('.hosts.yaml')) {
        import('.hosts.yaml');
    }
} catch (Exception\Exception $e) {
}

// Hooks

after('deploy:failed', 'deploy:unlock');
