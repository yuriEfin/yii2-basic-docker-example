<?php

namespace app\components\exceptions;

use Exception;
use Throwable;
use Yii;

class AbstractTranslateException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = Yii::t('app', $message);
        
        parent::__construct($message, $code, $previous);
    }
}