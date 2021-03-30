<?php

declare(strict_types=1);

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks;

use Astrotomic\Translatable\Contracts\Translatable;
use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;

class TranslatableHook implements ModelHookInterface
{
    public function run(ModelsCommand $command, Model $model): void
    {
        if (!$model instanceof Translatable) {
            return;
        }

        if (method_exists($model, 'getTranslationModelName')) {
            $className = $model->getTranslationModelName();
            $command->getPropertiesFromTable(new $className);
        }
    }
}
