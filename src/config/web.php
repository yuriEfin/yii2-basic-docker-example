<?php

use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return ArrayHelper::merge(
    [
        'id'         => 'app-identity',
        'basePath'   => dirname(__DIR__),
        'bootstrap'  => ['log'],
        'aliases'    => [
            '@bower' => '@vendor/bower-asset',
            '@npm'   => '@vendor/npm-asset',
        ],
        'components' => [
            'request'      => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'asdasdasd165486qw15164334l[}}{[***9aw',
            ],
            'cache'        => [
                'class' => 'yii\caching\FileCache',
            ],
            'user'         => [
                'identityClass'   => 'app\models\User',
                'enableAutoLogin' => true,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'mailer'       => [
                'class'            => 'yii\swiftmailer\Mailer',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
            'log'          => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets'    => [
                    [
                        'class'  => 'yii\log\FileTarget',
                        'levels' => ['error', 'warning'],
                    ],
                ],
            ],
            'db'           => $db,
            'urlManager'   => [
                'enablePrettyUrl' => true,
                'showScriptName'  => false,
                'normalizer'      => [
                    'class'                  => 'yii\web\UrlNormalizer',
                    'collapseSlashes'        => true,
                    'normalizeTrailingSlash' => false,
                ],
                'rules'           => [
                    'POST /v1/auth' => 'auth/index',
                ],
            ],
        ],
        'modules'    => [
            'oauth2' => [
                'class'               => 'filsh\yii2\oauth2server\Module',
                'tokenParamName'      => 'accessToken',
                'tokenAccessLifetime' => 3600 * 24,
                'storageMap'          => [
                    'user_credentials' => 'app\models\User',
                ],
                'grantTypes'          => [
                    'user_credentials' => [
                        'class' => 'OAuth2\GrantType\UserCredentials',
                    ],
                    'refresh_token'    => [
                        'class'                          => 'OAuth2\GrantType\RefreshToken',
                        'always_issue_new_refresh_token' => true,
                    ],
                ],
            ],
        ],
        'params'     => $params,
    ],
    require __DIR__ . '/local/web.php'
);
