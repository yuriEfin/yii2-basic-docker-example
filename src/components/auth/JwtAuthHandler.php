<?php

namespace app\components\auth;

use yii\redis\Connection;

class JwtAuthHandler
{
    private const PREFIX_KEY = '_user_token_';
    
    public function handle(AuthEvent $event)
    {
        /** @var Connection $redis */
        $redis = \Yii::$app->redis;
        $token = $event->token;
        if ($token) {
            $redis->set(self::PREFIX_KEY . $token->getClaim('uid'), (string)$token);
        }
    }
}
