<?php

namespace app\components\cleaner;

use app\components\cleaner\cleaners\CleanerRefreshToken;
use app\components\exceptions\NotFoundImplementationException;
use app\models\UserRefreshToken;

class CleanerFactory implements CleanerFactoryInterface
{
    public function createCleaner($table): CleanerInterface
    {
        $map = $this->getMap();
        $cleaner = $map[$table] ?? null;
        
        if (!$cleaner) {
            throw NotFoundImplementationException::create('Not found implementation cleaner for table: {table}', ['table' => $table]);
        }
        
        return new $cleaner();
    }
    
    private function getMap()
    {
        return [
            UserRefreshToken::tableName() => CleanerRefreshToken::class,
        ];
    }
}