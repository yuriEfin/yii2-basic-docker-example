<?php

namespace app\components\auth;

use Lcobucci\JWT\Token;
use yii\base\Event;

class AuthEvent extends Event
{
    public ?Token $token = null;
}