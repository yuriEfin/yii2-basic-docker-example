<?php

namespace app\components\cleaner\cleaners;

use app\components\cleaner\CleanerInterface;

class CleanerRefreshToken implements CleanerInterface
{
    public function clean(): bool
    {
        return true;
    }
}