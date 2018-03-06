<?php

use yii\db\Migration;

class m180303_071123_create_users_friends_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_friends', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_friend' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_friends');
    }
}
