<?php

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Providers;

use DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks\TranslatableHook;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;

class LaravelIdeHelperHookTranslatableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isProduction()) {
            return;
        }

        /** @var Config $config */
        $config = $this->app->get('config');

        $config->set('ide-helper.model_hooks', array_merge([
            TranslatableHook::class,
        ], $config->get('ide-helper.model_hooks', [])));
    }
}
