<?php

namespace app\components\cleaner;

interface CleanerFactoryInterface
{
    public function createCleaner($table): CleanerInterface;
}