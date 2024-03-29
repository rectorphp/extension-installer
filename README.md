# Rector Extension Installer

[![Build](https://github.com/rectorphp/extension-installer/actions/workflows/code_analysis.yaml/badge.svg)](https://github.com/rectorphp/extension-installer/actions)

Composer plugin for automatic installation of Rector extensions.

## Important Note

As this project became a part of a core project (`rector/rector`) it shouldn't be installed in addition if you already installed `rector/rector`. See comments [here](https://github.com/rectorphp/rector/issues/7092#issuecomment-1367967936).

## Usage

```bash
composer require --dev rector/extension-installer
```

## Instructions for extension developers

It's best to set the extension's composer package [type](https://getcomposer.org/doc/04-schema.md#type) to `rector-extension` for this plugin to be able to recognize it and to be [discoverable on Packagist](https://packagist.org/explore/?type=rector-extension).

Add `rector` key in the extension `composer.json`'s `extra` section:

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

The extension installer depends on Composer script events, therefore you cannot use `--no-scripts` flag.

## Acknowledgment
This package is heavily inspired by [phpstan/extension-installer](https://github.com/phpstan/extension-installer) by Ondřej Mirtes. Thank you.

