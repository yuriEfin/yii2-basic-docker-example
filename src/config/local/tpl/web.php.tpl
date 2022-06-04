<?php

$localConfig = [
    'components' => [
        'db' => require __DIR__ . '/db.php',
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $localConfig['bootstrap'][] = 'debug';
    $localConfig['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    
    $localConfig['bootstrap'][] = 'gii';
    $localConfig['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', 'web-auth:8081'],
    ];
}

return $localConfig;