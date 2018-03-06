<?php

use yii\db\Migration;

class m180303_071311_create_users_message_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_message', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_friend' => $this->integer()->notNull(),
            'message' => $this->text(),
            'status' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_message');
    }
}
