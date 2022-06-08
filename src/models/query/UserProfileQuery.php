<?php

declare(strict_types=1);

namespace app\models\query;

use app\models\User;

/**
 * This is the ActiveQuery class for [[\app\models\UserProfile]].
 *
 * @see \app\models\UserProfile
 */
class UserProfileQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $db
     *
     * @return array|User[]
     */
    public function all($db = null):array
    {
        return parent::all($db);
    }
    
    /**
     * @param $db
     *
     * @return User
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
