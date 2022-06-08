<?php

namespace app\components\auth;

use sizeg\jwt\JwtValidationData as BaseJwtValidationData;
use Yii;

class JwtValidationData extends BaseJwtValidationData
{
    public function init()
    {
        $jwtParams = Yii::$app->params['jwt'];
        $this->validationData->setIssuer($jwtParams['issuer']);
        $this->validationData->setAudience($jwtParams['audience']);
        $this->validationData->setId($jwtParams['id']);
        
        parent::init();
    }
}