<?php

use app\models\User;

return [
    'oauth2' => [
        'class'               => 'filsh\yii2\oauth2server\Module',
        'tokenParamName'      => 'accessToken',
        'tokenAccessLifetime' => 3600 * 24,
        'storageMap'          => [
            'user_credentials' => User::class,
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
];