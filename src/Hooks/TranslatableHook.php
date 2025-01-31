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
        if (
            ! $model instanceof Translatable || ! method_exists($model, 'getTranslationModelName') || ! property_exists($model, 'translatedAttributes')
        ) {
            return;
        }

        $className = $model->getTranslationModelName();

        /** @var Model $modelTranslation */
        $modelTranslation = $command->getLaravel()->make($className);

        $table = $modelTranslation->getConnection()->getTablePrefix().$modelTranslation->getTable();

        $columns = $modelTranslation->getConnection()->getSchemaBuilder()->getColumns($table);

        if (! $columns) {
            return;
        }

        foreach ($columns as $column) {
            $name = $column['name'];

            if (! in_array($name, $model->translatedAttributes)) {
                continue;
            }

            // Handle dates
            if (in_array($name, $modelTranslation->getDates())) {
                $type = $this->getDateClass();
            } else {
                $type = $column['type_name'];

                // Map the column types to PHP types
                switch ($type) {
                    case 'varchar':
                    case 'string':
                    case 'text':
                    case 'date':
                    case 'time':
                    case 'guid':
                    case 'datetimetz':
                    case 'datetime':
                    case 'decimal':
                        $type = 'string';
                        break;
                    case 'integer':
                    case 'bigint':
                    case 'smallint':
                        $type = 'integer';
                        break;
                    case 'boolean':
                        switch (config('database.default')) {
                            case 'sqlite':
                            case 'mysql':
                                $type = 'integer';
                                break;
                            default:
                                $type = 'boolean';
                                break;
                        }
                        break;
                    case 'float':
                        $type = 'float';
                        break;
                    default:
                        $type = 'mixed';
                        break;
                }
            }

            $command->setProperty(
                $name,
                $type,
                true,
                true,
                null,
                $column['nullable'],
            );
        }
    }

    protected function getDateClass(): string
    {
        return class_exists(\Illuminate\Support\Facades\Date::class)
            ? '\\'.get_class(\Illuminate\Support\Facades\Date::now())
            : '\Illuminate\Support\Carbon';
    }
}
