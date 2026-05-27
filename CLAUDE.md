# CLAUDE.md

## Package

`rector/extension-installer` — a Composer plugin that auto-discovers and registers Rector extensions installed in the host project. Inspired by `phpstan/extension-installer`.

Note: the functionality is also bundled into `rector/rector` core, so this plugin is only needed by projects that explicitly install it.

## Structure

- `src/Plugin.php` — Composer plugin entrypoint. Subscribes to `POST_INSTALL_CMD` / `POST_UPDATE_CMD` events.
- `src/PluginInstaller.php` — scans `InstalledRepository` for packages of type `rector-extension` (or packages declaring `extra.rector`) and writes their includes/version data to `src/GeneratedConfig.php`.
- `src/Filesystem.php` / `src/LocalFilesystem.php` — filesystem abstraction for testability.
- `e2e/` — integration test: installs the plugin against a real `rector/rector` + a real `rector-extension` and runs `rector` in dry-run.
- `.github/workflows/code_analysis.yaml` — PHPStan, ECS, Rector matrix.
- `.github/workflows/rector_install.yaml` — runs the `e2e/` flow.

## Discovery rules

A package is treated as a Rector extension when:
- `type` is `rector-extension`, **or**
- it declares an `extra.rector` key (e.g., `{ "extra": { "rector": { "includes": ["config/config.php"] } } }`).

## Commands

- `composer phpstan` — static analysis (level max, `src/`).
- `composer check-cs` / `composer fix-cs` — ECS.
- `composer rector` — Rector dry-run.

## Conventions

- PHP `^8.2`.
- `composer-plugin-api` `^2.0` only (Composer 1 dropped).
- ECS uses `ECSConfig::configure()` (PSR-12 + Symplify + Common + CleanCode prepared sets).
- Rector uses `RectorConfig::configure()` with PHP 8.2 set and the standard prepared sets.
- `GeneratedConfig.php` is generated at install/update time and is **not** committed.
