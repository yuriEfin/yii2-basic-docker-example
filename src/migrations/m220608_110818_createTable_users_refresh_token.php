<?php

use yii\db\Migration;

/**
 * Class m220608_110818_createTable_users_refresh_token
 */
class m220608_110818_createTable_users_refresh_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_refresh_tokens', [
            'user_refresh_token_id' => $this->primaryKey(10)->unsigned()->notNull(),
            'urf_user_id'           => $this->integer(10)->unsigned()->notNull(),
            'urf_token'             => $this->string(1000)->notNull(),
            'urf_ip'                => $this->string(50)->notNull(),
            'urf_user_agent'        => $this->string(1000)->notNull(),
            'urf_created'           => $this->timestamp(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_refresh_tokens');
    }
}
