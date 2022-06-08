<?php

declare(strict_types=1);

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';

return ArrayHelper::merge(
    [
        'id'         => 'app-identity',
        'basePath'   => dirname(__DIR__),
        'language'   => 'en',
        'bootstrap'  => ['log'],
        'aliases'    => [
            '@app'   => dirname(__DIR__),
            '@keys'  => dirname(__DIR__) . '/keys',
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
        ],
        'components' => array_merge(
            require __DIR__ . '/common/components.php',
            require __DIR__ . '/components.php',
        ),
        'modules'    => array_merge(
            require __DIR__ . '/modules.php',
            []
        ),
        'params'     => $params,
    ],
    require __DIR__ . '/local/web.php'
);
