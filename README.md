# Laravel IDE Helper Hook Translatable

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

## Credits

- [All Contributors](../../contributors)
