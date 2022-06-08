<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Class m220606_171600_create_table_user
 */
class m220606_171600_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string()->comment('Логин'),
            'password' => $this->string()->comment('Пароль'),
            'created_at' => $this->dateTime()->comment('Когда создан'),
        ]);

        $this->createTable('user_profile', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'username' => $this->string()->comment('Имя пользователя'),
            'lastname' => $this->string()->comment('Фамилия пользователя'),
            'fio' => $this->string()->comment('Фамилия Имя Отчество'),
            'full_address' => $this->string(350)->comment('Адрес'),
            'created_at' => $this->dateTime()->comment('Когда создан'),
            'created_by' => $this->string()->comment('Кем создан'),
        ]);

        $this->addForeignKey('fk_userProfile_to_user', 'user_profile', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('user');
        $this->dropTable('user_profile');
    }
}
