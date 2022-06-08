<?php

use app\components\auth\JwtValidationData;
use sizeg\jwt\Jwt;
use yii\redis\Connection as RedisConnection;

$db = require dirname(__DIR__) . '/db.php';

return [
    'db'    => $db,
    'redis' => [
        'class'    => RedisConnection::class,
        'hostname' => 'redis-auth-server',
        'port'     => 6379,
        'database' => 0,
    ],
    'i18n'  => [
        'translations' => [
            '*' => [
                'class'          => 'yii\i18n\PhpMessageSource',
                'basePath'       => '@app/messages',
                'sourceLanguage' => 'ru',
                'fileMap'        => [
                    'app'   => 'app.php',
                    'error' => 'error.php',
                    'yii'   => 'app.php',
                ],
            ],
        ],
    ],
    'jwt'   => [
        'class'             => Jwt::class,
        'key'               => 'file://' . (dirname(__DIR__, 2) . '/keys/jwtRS256.key.pub'), //typically a long random string
        'jwtValidationData' => JwtValidationData::class,
    ],
];