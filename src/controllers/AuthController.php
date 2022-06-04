<?php

namespace app\controllers;

use filsh\yii2\oauth2server\Module as OAuth2ServerModule;
use Yii;
use yii\base\InvalidConfigException;

class AuthController extends AbstractController
{
    private const OAUTH2_SERVER_MODULE = 'oauth2';
    private ?OAuth2ServerModule $authModule;
    
    public function init()
    {
        $this->authModule = Yii::$app->getModule(self::OAUTH2_SERVER_MODULE);
        parent::init();
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        if (Yii::$app->getUser()->getIsGuest()) {
            return $this->redirect('login');
        }
        
        $response = $this->authModule->getServer()->handleAuthorizeRequest(
            null,
            null,
            !Yii::$app->getUser()->getIsGuest(),
            Yii::$app->getUser()->getId()
        );
        
        /** @var object $response \OAuth2\Response */
        Yii::$app->getResponse()->format = \yii\web\Response::FORMAT_JSON;
        
        return $response->getParameters();
    }
}