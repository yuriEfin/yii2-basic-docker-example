<?php

declare(strict_types=1);

namespace app\models;

use app\models\query\UserQuery;
use OAuth2\Storage\UserCredentialsInterface;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface, UserCredentialsInterface
{
    public const STATUS_ACTIVE = 1;
    
    public ?string $username = null;
    public ?string $authKey = null;
    public ?string $accessToken = null;
    public ?string $password = null;
    public ?string $password_hash = null;
    
    public static function tableName(): string
    {
        return '{{%user}}';
    }
    
    public function rules()
    {
        return [
            [['username', 'password', 'authKey', 'accessToken', 'password_hash'], 'string'],
        ];
    }
    
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return self::findOne($token->getClaim('uid'));
    }
    
    public static function findByUsername(string $username): ?User
    {
        /** @var self $user */
        $user = self::find()
            ->joinWith('profile')
            ->where(['login' => $username])
            ->one();
        
        return $user;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }
    
    public function validateAuthKey($authKey): ?bool
    {
        return $this->authKey === $authKey;
    }
    
    public function validatePassword($password): bool
    {
        $this->password = $password;
        $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function fields(): array
    {
        return [
            'id',
            'login',
        ];
    }
    
    public function extraFields(): array
    {
        return [
            'profile',
        ];
    }
    
    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }
    
    public static function findIdentityByUsername($username): self
    {
        return self::findOne(['username' => $username]);
    }
    
    public function checkUserCredentials($username, $password): self
    {
        /** @var self $user */
        $user = self::find()
            ->joinWith('profile')
            ->where(['username' => $username, 'password' => $password])
            ->one();
        
        return $user;
    }
    
    public function getUserDetails($username)
    {
        return self::find()
            ->joinWith('profile')
            ->where(['username' => $username])
            ->one();
    }
    
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
