<?php

declare(strict_types=1);

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Tests\Integration;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks\TranslatableHook;
use DanielDeWit\LaravelIdeHelperHookTranslatable\Providers\LaravelIdeHelperHookTranslatableServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

class LaravelIdeHelperHookTranslatableServiceProviderTest extends TestCase
{
    /**
     * {@inheritDoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            IdeHelperServiceProvider::class,
            LaravelIdeHelperHookTranslatableServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function it_auto_registers_model_hook(): void
    {
        /** @var Application $app */
        $app = $this->app;

        $app->loadDeferredProvider(IdeHelperServiceProvider::class);
        $app->loadDeferredProvider(LaravelIdeHelperHookTranslatableServiceProvider::class);

        /** @var Repository $config */
        $config = $app->get('config');

        $this->assertContains(
            TranslatableHook::class,
            (array) $config->get('ide-helper.model_hooks', []),
        );
    }

    /**
     * @test
     */
    public function it_auto_registers_model_hook_with_wrong_service_provider_order(): void
    {
        /** @var Application $app */
        $app = $this->app;

        $app->loadDeferredProvider(LaravelIdeHelperHookTranslatableServiceProvider::class);
        $app->loadDeferredProvider(IdeHelperServiceProvider::class);

        /** @var Repository $config */
        $config = $app->get('config');

        $this->assertContains(
            TranslatableHook::class,
            (array) $config->get('ide-helper.model_hooks', []),
        );
    }
}
