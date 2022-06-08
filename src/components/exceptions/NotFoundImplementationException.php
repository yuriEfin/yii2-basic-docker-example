<?php

namespace app\components\exceptions;

class NotFoundImplementationException extends AbstractTranslateException
{
    public static function create($message, $params)
    {
        return new self($message, $params);
    }
}