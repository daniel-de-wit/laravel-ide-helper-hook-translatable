<?php

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Providers;

use DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks\TranslatableHook;
use Illuminate\Support\ServiceProvider;

class LaravelIdeHelperHookTranslatableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isProduction()) {
            return;
        }

        config([
            'ide-helper.model_hooks' => array_merge([
                TranslatableHook::class,
            ], config('ide-helper.model_hooks', [])),
        ]);
    }
}
