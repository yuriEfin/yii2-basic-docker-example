<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_refresh_tokens}}".
 *
 * @property int $user_refresh_token_id
 * @property int $urf_user_id
 * @property string $urf_token
 * @property string $urf_ip
 * @property string $urf_user_agent
 * @property string $urf_created
 */
class UserRefreshToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_refresh_tokens}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urf_user_id', 'urf_token', 'urf_ip', 'urf_user_agent'], 'required'],
            [['urf_user_id'], 'integer'],
            [['urf_created'], 'safe'],
            [['urf_token', 'urf_user_agent'], 'string', 'max' => 1000],
            [['urf_ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_refresh_token_id' => Yii::t('app', 'User Refresh Token ID'),
            'urf_user_id' => Yii::t('app', 'Urf User ID'),
            'urf_token' => Yii::t('app', 'Urf Token'),
            'urf_ip' => Yii::t('app', 'Urf Ip'),
            'urf_user_agent' => Yii::t('app', 'Urf User Agent'),
            'urf_created' => Yii::t('app', 'Urf Created'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserRefreshTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserRefreshTokenQuery(get_called_class());
    }
}
