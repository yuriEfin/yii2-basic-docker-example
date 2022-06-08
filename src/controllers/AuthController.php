<?php

namespace app\controllers;

use app\components\auth\AuthEvent;
use app\components\auth\JwtAuthHandler;
use app\components\exceptions\auth\UnauthorizedHttpException;
use app\models\LoginForm;
use app\models\User;
use app\models\UserRefreshToken;
use sizeg\jwt\Jwt;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\rest\Controller;
use yii\web\Cookie;
use yii\web\ServerErrorHttpException;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class'  => JwtHttpBearerAuth::class,
            'except' => [
                'login',
                'refresh-token',
                'options',
            ],
        ];
        
        return $behaviors;
    }
    
    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->login()) {
            $user = Yii::$app->user->identity;
            
            $token = $this->generateJwt($user);
            
            $this->generateRefreshToken($user);
            Yii::$app->on(AuthEvent::class, [JwtAuthHandler::class, 'handle']);
            Yii::$app->trigger(
                AuthEvent::class,
                new AuthEvent(
                    [
                        'user_id' => $model->user->getId(),
                        'token'   => $token,
                    ]
                )
            );
            
            return [
                'user'       => $user,
                'token'      => (string)$token,
                'tokenRedis' => Yii::$app->redis->get('_user_token_1'),
            ];
        }
        
        return $model->getErrors();
    }
    
    private function generateJwt(User $user)
    {
        /** @var Jwt $jwt */
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('RS256');
        $key = $jwt->getKey('file://' . dirname(__DIR__) . '/keys/jwtRS256.key', 'mrHDXedN92g4dbderWgSFm5KzOTcOP1Ls6cL4Og2mfw');
        $time = time();
        
        $jwtParams = Yii::$app->params['jwt'];
        
        return $jwt->getBuilder()
            ->issuedBy($jwtParams['issuer'])
            ->permittedFor($jwtParams['audience'])
            ->identifiedBy($jwtParams['id'], true)
            ->issuedAt($time)
            ->expiresAt($time + $jwtParams['expire'])
            ->withClaim('uid', $user->id)
            ->getToken($signer, $key);
    }
    
    /**
     * @throws yii\base\Exception
     */
    private function generateRefreshToken(\app\models\User $user, \app\models\User $impersonator = null): \app\models\UserRefreshToken
    {
        $refreshToken = Yii::$app->security->generateRandomString(200);
        
        // TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
        $userRefreshToken = new UserRefreshToken(
            [
                'urf_user_id'    => $user->id,
                'urf_token'      => $refreshToken,
                'urf_ip'         => Yii::$app->request->getUserIP(),
                'urf_user_agent' => Yii::$app->request->getUserAgent(),
                'urf_created'    => gmdate('Y-m-d H:i:s'),
            ]
        );
        if (!$userRefreshToken->save()) {
            throw new ServerErrorHttpException('Failed to save the refresh token: ' . (print_r($userRefreshToken->getErrorSummary(true), true)));
        }
        
        // Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
        Yii::$app->response->cookies->add(
            new Cookie(
                [
                    'name'     => 'refresh-token',
                    'value'    => $refreshToken,
                    'httpOnly' => true,
                    'sameSite' => 'none',
                    'secure'   => true,
                    'path'     => '/v1/auth/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
                ]
            )
        );
        
        return $userRefreshToken;
    }
    
    public function actionRefreshToken()
    {
        $refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
        if (!$refreshToken) {
            return new UnauthorizedHttpException('No refresh token found.');
        }
        
        $userRefreshToken = UserRefreshToken::findOne(['urf_token' => $refreshToken]);
        
        if (Yii::$app->request->getMethod() == 'POST') {
            // Getting new JWT after it has expired
            if (!$userRefreshToken) {
                return new UnauthorizedHttpException('The refresh token no longer exists.');
            }
            
            $user = \app\models\User::find()  //adapt this to your needs
            ->where(['user_id' => $userRefreshToken->urf_user_id])
                ->active()
                ->one();
            if (!$user) {
                $userRefreshToken->delete();
                
                return new UnauthorizedHttpException('The user is inactive.');
            }
            
            $token = $this->generateJwt($user);
            
            return [
                'status' => 'ok',
                'token'  => (string)$token,
            ];
        } elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Logging out
            if ($userRefreshToken && !$userRefreshToken->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }
            
            return ['status' => 'ok'];
        }
        
        return new \yii\web\UnauthorizedHttpException('The user is inactive.');
    }
}