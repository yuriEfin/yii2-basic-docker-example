<?php

use yii\db\Migration;

/**
 * Class m220608_133950_addColumn_status_id_to_table_user
 */
class m220608_133950_addColumn_status_id_to_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'status_id', $this->integer()->unsigned()->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'status_id');
    }
}
