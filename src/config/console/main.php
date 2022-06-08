<?php

declare(strict_types=1);

use app\components\cleaner\CleanerFactory;
use app\components\cleaner\CleanerFactoryInterface;
use yii\console\controllers\MigrateController;

$params = require dirname(__DIR__) . '/params.php';
$db = require dirname(__DIR__) . '/db.php';

return array_merge(
    [
        'id'                  => 'basic-console',
        'basePath'            => dirname(__DIR__, 2),
        'bootstrap'           => ['log'],
        'controllerNamespace' => 'app\commands',
        'aliases'             => [
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
            '@tests' => '@app/tests',
        ],
        'container'           => [
            'definitions' => [
            ],
            'singletons'  => [
                CleanerFactoryInterface::class => CleanerFactory::class,
            ],
        ],
        'components'          => array_merge(
            require __DIR__.'/components.php',
            require dirname(__DIR__).'/common/components.php',
        ),
        'params'              => $params,
        'controllerMap'       => [
            'fixture' => [ // Fixture generation command line.
                'class' => 'yii\faker\FixtureController',
            ],
            'migrate' => [
                'class'               => MigrateController::class,
                'migrationPath'       => [
                    '@app/migrations',
                ],
                // ...
                'migrationNamespaces' => [
                ],
            ],
        ],
    ],
    require dirname(__DIR__) . '/local/console.php'
);
