<?php

namespace app\components\auth;

use app\components\redis\RedisSentinelInterface;
use PSRedis\HAClient;
use Yii;

class JwtAuthHandler
{
    private const PREFIX_KEY = '_user_token_';
    
    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function handle(AuthEvent $event)
    {
        /** @var HAClient $redis */
        $redis = Yii::$app->redis;
        $token = $event->token;
        $jwtParams = Yii::$app->params['jwt'];
        $key = self::PREFIX_KEY . $token->getClaim('uid');
        $strToken = (string)$token;
        $redis->set($key, $strToken);
    }
}
