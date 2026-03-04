# AGENTS.md

## Purpose
- This file is guidance for coding agents working in this repository.
- Prefer existing repository conventions over generic framework advice.
- Keep changes small, reviewable, and focused.

## Repository Snapshot
- App: Kimai (Symfony + Doctrine + Twig + JS/Webpack Encore).
- PHP: `8.1+` (CI tests up to `8.5`).
- Frontend tooling: `yarn` + Encore + ESLint.
- Main source folders: `src/`, `templates/`, `assets/js/`, `tests/`, `migrations/`.

## Rule Files (Cursor/Copilot)
- Checked for Cursor rules in `.cursor/rules/` and `.cursorrules`: none found.
- Checked for Copilot rules in `.github/copilot-instructions.md`: none found.
- If these files are added later, treat them as highest-priority local agent rules.

## Setup And Environment
- Install PHP dependencies: `composer install`.
- Install frontend dependencies: `yarn install`.
- Local container workflow uses DDEV (`.ddev/config.yaml`):
  - Run commands in container: `ddev exec <command>`.
  - Example: `ddev exec composer tests`.
- Typical cache warmup after dependency or config changes:
  - `APP_ENV=dev bin/console kimai:reload -n`

## Build Commands
- Dev build once: `yarn dev`.
- Dev build watch mode: `yarn watch`.
- Dev server: `yarn dev-server`.
- Production build: `yarn build`.
- Encore config lives in `webpack.config.js`.

## Lint And Static Analysis
- PHP CS check (no write): `composer codestyle`.
- PHP CS auto-fix: `composer codestyle-fix`.
- PHPStan (app + tests): `composer phpstan`.
- PHPStan app only: `composer phpstan-src`.
- PHPStan tests only: `composer phpstan-tests`.
- Symfony/Doctrine/Twig/YAML/XLIFF linting: `composer linting`.
- JS linting: `yarn lint`.

## Test Commands
- Full test suite: `composer tests` or `vendor/bin/phpunit tests/`.
- Unit-focused suite: `composer tests-unit`.
- Integration-only suite: `composer tests-integration`.

## Single Test Execution (Important)
- Run one test file:
  - `vendor/bin/phpunit tests/API/ActivityControllerTest.php`
- Run one test method:
  - `vendor/bin/phpunit tests/API/ActivityControllerTest.php --filter testPostAction`
- Run one data-provider case or partial method name:
  - `vendor/bin/phpunit tests/API/ActivityControllerTest.php --filter "testGetCollection"`
- Run all tests from one class name pattern:
  - `vendor/bin/phpunit tests/ --filter ActivityControllerTest`
- DDEV equivalent:
  - `ddev exec vendor/bin/phpunit tests/API/ActivityControllerTest.php --filter testPostAction`

## Plugin-Scoped Helpers
- PHPStan helper script for core/tests/plugins: `./phpstan.sh`.
- CS fixer helper script for core/plugins: `./php-cs-fixer.sh`.
- Example plugin check: `./phpstan.sh Import --level=9`.

## Formatting Baseline
- Follow `.editorconfig`:
  - UTF-8, LF line endings.
  - 4 spaces for `*.php`, `*.twig`, `*.yaml`, `*.yml`.
- Let automated tools enforce style whenever possible.
- Do not manually reformat unrelated files.

## PHP Style Guidelines
- Keep the project file header comment block in PHP files.
- Namespace under `App\...` for core code; match PSR-4 paths.
- Use one import per `use` statement.
- Keep imports ordered and remove unused imports (php-cs-fixer enforces this).
- Prefer short arrays (`[]`) over `array()`.
- Prefer strict comparisons (`===`, `!==`) over loose checks.
- In namespaced files, native functions are commonly called as `\functionName()`.
- Use `final` for classes that are not designed for extension.
- Use constructor property promotion and `private readonly` where appropriate.
- Keep methods small and side effects explicit.

## Types And PHPDoc
- Add parameter and return types whenever feasible.
- Use nullable types explicitly (`?Type`) instead of mixed null behavior.
- Keep PHPDoc aligned with real types; do not add stale annotations.
- Use generics in docblocks for collections/iterables when native types cannot express them.
- Avoid introducing new `mixed` usage unless absolutely required by framework boundaries.
- Do not lower analysis strictness to bypass PHPStan findings.

## Naming Conventions
- Classes/interfaces/traits: `PascalCase`.
- Methods/properties/variables: `camelCase`.
- Constants: `UPPER_SNAKE_CASE`.
- Test methods should describe behavior (`testXyz...`).
- Keep file names aligned with class names.
- Keep route names and API identifiers consistent with existing patterns.

## Architecture And Boundaries
- Keep controllers thin; delegate business logic to services.
- Use repositories/query objects for database retrieval logic.
- Keep entity logic cohesive; avoid moving business rules into controllers.
- Reuse existing services/forms/events before creating new abstractions.
- Follow existing patterns in neighboring files before introducing new ones.

## Error Handling
- Fail fast on invalid input.
- In controllers, prefer framework-native exceptions:
  - `createNotFoundException()` for missing entities.
  - `createAccessDeniedException()` for permission failures.
- Return proper HTTP status codes via `Response::HTTP_*` constants.
- Do not swallow exceptions silently.
- In JS async code, reject promises with meaningful errors/responses.

## Testing Expectations For Changes
- Add or update tests when behavior changes.
- For API/controller changes, prefer integration tests in `tests/API` or `tests/Controller`.
- Keep fixtures deterministic and minimal.
- Verify both happy path and at least one failure/permission path.
- Before finalizing substantial changes, run:
  - `composer codestyle`
  - `composer phpstan`
  - `composer tests-unit`

## JavaScript Guidelines
- Use ES modules (`import`/`export`) and existing class-based plugin style.
- Keep plugin/component names in `PascalCase` files under `assets/js/`.
- Use semicolons.
- Prefer `const`/`let` over `var`.
- Prefer `===`/`!==` (ESLint `eqeqeq` is enabled).
- Avoid introducing new frontend frameworks.

## Twig And Templates
- Follow existing Twig structure and reuse macros/partials.
- Keep presentation logic in templates, business logic in PHP services.
- Respect existing translation and escaping patterns.

## Migration And Generated Assets
- Do not hand-edit generated files in `public/build/`.
- Edit source assets in `assets/` and rebuild.
- Database migrations commonly use `declare(strict_types=1);`; follow existing migration style.

## Agent Workflow Checklist
- Read nearby files first and mirror local conventions.
- Make the smallest safe change that solves the task.
- Run targeted checks first, then broader checks as needed.
- Mention exactly which commands were run and what passed/failed.
- If uncertain, choose consistency with existing code over novelty.
