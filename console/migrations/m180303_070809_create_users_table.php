<?php

use yii\db\Migration;

class m180303_070809_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull()->unique(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'verified' => $this->integer()->notNull(),
            'token' => $this->string(255),
            'status' => $this->integer()->notNull(),
            'date' => $this->dateTime()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }
}
