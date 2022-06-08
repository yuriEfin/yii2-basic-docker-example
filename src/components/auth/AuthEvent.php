<?php

namespace app\components\auth;

use Lcobucci\JWT\Token;
use yii\base\Event;

class AuthEvent extends Event
{
    public int $user_id;
    public ?Token $token = null;
}