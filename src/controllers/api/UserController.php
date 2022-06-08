<?php

declare(strict_types=1);

namespace app\controllers\api;

use app\controllers\api\common\AbstractApiController;
use app\models\User;

class UserController extends AbstractApiController
{
    public $modelClass = User::class;
}
