<?php

namespace app\commands;

use app\components\cleaner\CleanerFactoryInterface;
use yii\console\Controller;
use yii\console\ExitCode;

class CleanerController extends Controller
{
    private ?CleanerFactoryInterface $cleanerFactory;
    
    public function __construct($id, $module, CleanerFactoryInterface $cleanerFactory, $config = [])
    {
        parent::__construct($id, $module, $config);
        
        $this->cleanerFactory = $cleanerFactory;
    }
    
    public function actionCleanTable(string $table)
    {
        if ($this->cleanerFactory->createCleaner($table)->clean()) {
            return ExitCode::OK;
        }
        
        return ExitCode::UNSPECIFIED_ERROR;
    }
}