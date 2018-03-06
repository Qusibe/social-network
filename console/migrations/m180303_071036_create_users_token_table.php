<?php

use yii\db\Migration;

class m180303_071036_create_users_token_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_token', [
            'id_user' => $this->primaryKey(),
            'token' => $this->string(255),
            'date' => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_token');
    }
}
