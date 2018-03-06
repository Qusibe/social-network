<?php

use yii\db\Migration;

class m180303_071715_create_participants_groups_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('participants_groups', [
            'id' => $this->primaryKey(),
            'id_groups' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('participants_groups');
    }
}
