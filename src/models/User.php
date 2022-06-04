<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public ?int $id = null;
    public ?string $username = null;
    public ?string $password = null;
    public ?string $authKey = null;
    public ?string $accessToken = null;
    
    public static function tableName()
    {
        return '{{%oauth_users}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return null;
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername(string $username): ?User
    {
        return self::findOne(['username' => $username]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }
    
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->authKey === $authKey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return $this->password === $password;
    }
}
