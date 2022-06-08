<?php

declare(strict_types=1);

namespace app\models;

use app\models\query\UserProfileQuery;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property int         $id
 * @property int|null    $user_id      Пользователь
 * @property string|null $username     Имя пользователя
 * @property string|null $lastname     Фамилия пользователя
 * @property string|null $fio          Фамилия Имя Отчество
 * @property string|null $full_address Адрес
 * @property string|null $created_at   Когда создан
 * @property string|null $created_by   Кем создан
 * @property User        $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_profile}}';
    }
    
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['username', 'lastname', 'fio', 'created_by'], 'string', 'max' => 255],
            [['full_address'], 'string', 'max' => 350],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'user_id'      => Yii::t('app', 'Пользователь'),
            'username'     => Yii::t('app', 'Имя пользователя'),
            'lastname'     => Yii::t('app', 'Фамилия пользователя'),
            'fio'          => Yii::t('app', 'Фамилия Имя Отчество'),
            'full_address' => Yii::t('app', 'Адрес'),
            'created_at'   => Yii::t('app', 'Когда создан'),
            'created_by'   => Yii::t('app', 'Кем создан'),
        ];
    }
    
    public function fields()
    {
        return [
            'id',
            'user_id',
            'username',
            'lastname',
            'fio',
            'full_address',
        ];
    }
    
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    public static function find(): UserProfileQuery
    {
        return new UserProfileQuery(get_called_class());
    }
}
