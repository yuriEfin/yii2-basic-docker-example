<?php

namespace app\components\cleaner;

interface CleanerInterface
{
    public function clean(): bool;
}