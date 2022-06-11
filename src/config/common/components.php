<?php

use app\components\auth\JwtValidationData;
use app\components\redis\RedisSentinelInterface;
use sizeg\jwt\Jwt;

$db = require dirname(__DIR__) . '/db.php';

return [
    'db'    => $db,
    'redis' => [
        'class' => RedisSentinelInterface::class,
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
        'key'               => 'file://' . (dirname(__DIR__, 2) . '/keys/jwtRS256.key.pub'),
        'jwtValidationData' => JwtValidationData::class,
    ],
];