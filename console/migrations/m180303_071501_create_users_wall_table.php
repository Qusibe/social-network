<?php

use yii\db\Migration;

class m180303_071501_create_users_wall_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_wall', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_friend' => $this->integer()->notNull(),
            'message' => $this->string(255),
            'way_file' => $this->string(255),
            'format' => $this->string(255)
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_wall');
    }
}
