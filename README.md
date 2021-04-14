# Laravel IDE Helper Hook Translatable

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/daniel-de-wit/laravel-ide-helper-hook-translatable/run-tests?label=tests)](https://github.com/daniel-de-wit/laravel-ide-helper-hook-translatable/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Coverage Status](https://coveralls.io/repos/github/daniel-de-wit/laravel-ide-helper-hook-translatable/badge.svg?branch=master)](https://coveralls.io/github/daniel-de-wit/laravel-ide-helper-hook-translatable?branch=master)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/daniel-de-wit/laravel-ide-helper-hook-translatable.svg?style=flat-square)](https://packagist.org/packages/daniel-de-wit/laravel-ide-helper-hook-translatable)
[![Total Downloads](https://img.shields.io/packagist/dt/daniel-de-wit/laravel-ide-helper-hook-translatable.svg?style=flat-square)](https://packagist.org/packages/daniel-de-wit/laravel-ide-helper-hook-translatable)

A Laravel Package for adding [Laravel Translatable](https://github.com/Astrotomic/laravel-translatable) support to Laravel IDE Helper [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper).

## Installation

You can install the package via composer:

```bash
composer require --dev daniel-de-wit/laravel-ide-helper-hook-translatable
```

The Translatable Hook is loaded using [Package Discovery](https://laravel.com/docs/8.x/packages#package-discovery), when disabled read [Manual Installation](#manual-installation).

## Usage

Run standard model generation commands as normal:

`php artisan ide-helper:models "App\Models\Post"`

## Manual Installation
When disabled, register the LaravelIdeHelperHookTranslatableServiceProvider manually by adding it to your config/app.php
```php
/*
 * Package Service Providers...
 */
 DanielDeWit\LaravelIdeHelperHookTranslatable\Providers\LaravelIdeHelperHookTranslatableServiceProvider::class,
```

## Testing

```bash
composer test
```


## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
