<?php

namespace app\controllers\api\common;

use yii\rest\ActiveController as RestActiveController;

class AbstractApiController extends RestActiveController
{
    public function behaviors(): array
    {
        return [
        
        ];
    }
}