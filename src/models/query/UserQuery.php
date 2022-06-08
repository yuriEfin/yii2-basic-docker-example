<?php

declare(strict_types=1);

namespace app\models\query;

use app\models\User;

/**
 * This is the ActiveQuery class for [[\app\models\UserProfile]].
 *
 * @see \app\models\UserProfile
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere('status=:status', [':status' => User::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     *
     * @return \app\models\UserProfile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return \app\models\UserProfile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
