<?php

use yii\i18n\PhpMessageSource;
use yii\log\FileTarget;
use yii\web\Response;
use yii\web\UrlNormalizer;

return [
    'request'      => [
        'class'                => \yii\web\Request::class,
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey'  => 'asdasdasd165486qw15164334l[}}{[***9aw',
        'baseUrl'              => '/api',
        'enableCsrfValidation' => false,
    ],
    'response'     => [
        'class'  => Response::class,
        'format' => Response::FORMAT_JSON,
    ],
    'cache'        => [
        'class' => 'yii\caching\FileCache',
    ],
    'user'         => [
        'identityClass'   => 'app\models\User',
        'enableAutoLogin' => false,
        'enableSession'   => false,
        'loginUrl'        => null,
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
                'class'  => FileTarget::class,
                'levels' => ['error', 'warning'],
            ],
        ],
    ],
    'urlManager'   => [
        'enablePrettyUrl' => true,
//        'enableStrictParsing' => true,
        'showScriptName'  => false,
        'normalizer'      => [
            'class'                  => UrlNormalizer::class,
            'collapseSlashes'        => true,
            'normalizeTrailingSlash' => false,
        ],
        'rules'           => [],
    ],
    'assetManager' => [
        'class'    => \yii\web\AssetManager::class,
        'baseUrl'  => '/api',
        'basePath' => '@app/web/api',
    ],
    'i18n'         => [
        'translations' => [
            'conquer/oauth2' => [
                'class'    => PhpMessageSource::class,
                'basePath' => '@conquer/oauth2/messages',
            ],
        ],
    ],
];