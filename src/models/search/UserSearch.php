<?php

declare(strict_types=1);

namespace app\models\search;

use app\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{
    public int $id;
    public ?string $username;
    public ?string $lastname;
    public ?string $fio;
    public ?string $login;

    public function rules(): array
    {
        return [
            ['id', 'int'],
            [['username', 'lastname', 'fio', 'login'], 'string'],
        ];
    }

    public function search()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => User::find(),
            ]
        );

        return $dataProvider;
    }
}
