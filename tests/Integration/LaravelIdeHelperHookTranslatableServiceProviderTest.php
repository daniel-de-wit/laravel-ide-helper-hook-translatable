<?php

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Tests\Integration;

use DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks\TranslatableHook;
use DanielDeWit\LaravelIdeHelperHookTranslatable\Providers\LaravelIdeHelperHookTranslatableServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelIdeHelperHookTranslatableServiceProviderTest extends TestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelIdeHelperHookTranslatableServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function it_adds_the_translatable_hook_to_the_config(): void
    {
        static::assertContains(TranslatableHook::class, config('ide-helper.model_hooks'));
    }
}
