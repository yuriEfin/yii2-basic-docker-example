<?php

return [
    'class'               => 'yii\db\Connection',
    'dsn'                 => 'mysql:host=auth-server-mysql;dbname=auth_identity',
    'username'            => 'root',
    'password'            => 'qwqwqw',
    'charset'             => 'utf8',
    
    // Schema cache options (for production environment)
    'enableSchemaCache'   => true,
    'schemaCacheDuration' => 60,
    'schemaCache'         => 'cache',
];
