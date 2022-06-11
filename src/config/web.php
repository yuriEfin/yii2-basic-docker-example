<?php

declare(strict_types=1);

use app\components\redis\RedisSentinelInterface;
use PSRedis\Client;
use PSRedis\HAClient;
use PSRedis\MasterDiscovery;
use yii\di\Container;
use yii\helpers\ArrayHelper;

$params = require __DIR__ . '/params.php';

return ArrayHelper::merge(
    [
        'id'         => 'app-identity',
        'basePath'   => dirname(__DIR__),
        'language'   => 'en',
        'bootstrap'  => ['log'],
        'container'  => [
            'definitions' => [
                RedisSentinelInterface::class => function (Container $container) {
                    $sentinels = [
                        [
//                            'h' => 'authidentity_redis-sentinel_1',
                                                        'h' => '172.25.0.8',
                            //                            'h' => 'sentinel_1',
//                            'h' => '172.24.0.3',
                            //                            'h' => '127.0.0.1',
                            'p' => 26379,
                        ],
                        [
//                            'h' => 'authidentity_redis-sentinel_2',
                                                        'h' => '172.25.0.2',
                            //                            'h' => 'sentinel_2',
//                            'h' => '172.25.0.2',
                            //                            'h' => '127.0.0.1',
                            'p' => 26379,
                        ],
                        [
//                            'h' => 'authidentity_redis-sentinel_3',
//                                                        'h' => '172.25.0.8',
                            //                            'h' => 'sentinel_3',
//                            'h' => '172.25.0.7',
                            //                            'h' => '127.0.0.1',
                            'p' => 26379,
                        
                        ],
                    ];
                    $masterDiscovery = new MasterDiscovery('master-node');
                    
                    foreach ($sentinels as $sentinel) {
                        $masterDiscovery->addSentinel(new Client($sentinel['h'], $sentinel['p']));
                    }
                    
                    return new HAClient($masterDiscovery);
                },
            ],
            'singletons'  => [
            
            ],
        ],
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
