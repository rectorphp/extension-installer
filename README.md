# Rector Extension Installer

[![Build](https://github.com/rectorphp/extension-installer/actions/workflows/code_analysis.yaml/badge.svg)](https://github.com/rectorphp/extension-installer/actions)

Composer plugin for automatic installation of Rector extensions.

## Important Note

This functionality is now part of `rector/rector` core, so you don't need to install this plugin separately if `rector/rector` is already installed. See comments [here](https://github.com/rectorphp/rector/issues/7092#issuecomment-1367967936).

## Usage

```bash
composer require --dev rector/extension-installer
```

## Instructions for extension developers

Set the extension's Composer package [type](https://getcomposer.org/doc/04-schema.md#type) to `rector-extension` so this plugin can recognize it and so it becomes [discoverable on Packagist](https://packagist.org/explore/?type=rector-extension).

Add a `rector` key to the extension's `composer.json` `extra` section:

```json
{
    "extra": {
        "rector": {
            "includes": [
                "config/config.php"
            ]
        }
    }
}
```

## Limitations

The extension installer depends on Composer script events, so you cannot use the `--no-scripts` flag.

## Acknowledgment

This package is heavily inspired by [phpstan/extension-installer](https://github.com/phpstan/extension-installer) by Ondřej Mirtes. Thank you.
