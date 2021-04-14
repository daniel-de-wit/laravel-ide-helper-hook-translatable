<?php

declare(strict_types=1);

namespace DanielDeWit\LaravelIdeHelperHookTranslatable\Hooks;

use Astrotomic\Translatable\Contracts\Translatable;
use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class TranslatableHook implements ModelHookInterface
{
    public function run(ModelsCommand $command, Model $model): void
    {
        if (
            ! $model instanceof Translatable ||
            ! method_exists($model, 'getTranslationModelName') ||
            ! property_exists($model, 'translatedAttributes')
        ) {
            return;
        }

        $className = $model->getTranslationModelName();

        /** @var Model $modelTranslation */
        $modelTranslation = $command->getLaravel()->make($className);

        $table = $modelTranslation->getConnection()->getTablePrefix() . $modelTranslation->getTable();
        $schema = $modelTranslation->getConnection()->getDoctrineSchemaManager();
        $databasePlatform = $schema->getDatabasePlatform();
        $databasePlatform->registerDoctrineTypeMapping('enum', 'string');

        $platformName = $databasePlatform->getName();

        /** @var Config $config */
        $config = $command->getLaravel()->make(Config::class);

        $customTypes = $config->get("ide-helper.custom_db_types.{$platformName}", []);
        foreach ($customTypes as $yourTypeName => $doctrineTypeName) {
            $databasePlatform->registerDoctrineTypeMapping($yourTypeName, $doctrineTypeName);
        }

        $database = null;
        if (strpos($table, '.')) {
            [$database, $table] = explode('.', $table);
        }

        $columns = $schema->listTableColumns($table, $database);

        if (!$columns) {
            return;
        }

        foreach ($columns as $column) {
            $name = $column->getName();

            if (! in_array($name, $model->translatedAttributes)) {
                continue;
            }

            if (in_array($name, $modelTranslation->getDates())) {
                $type = $this->getDateClass();
            } else {
                $type = $column->getType()->getName();
                switch ($type) {
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

            $comment = $column->getComment();
            $command->setProperty(
                $name,
                $type,
                true,
                true,
                $comment,
                true,
            );
        }
    }


    protected function getDateClass(): string
    {
        return class_exists(\Illuminate\Support\Facades\Date::class)
            ? '\\' . get_class(\Illuminate\Support\Facades\Date::now())
            : '\Illuminate\Support\Carbon';
    }
}
