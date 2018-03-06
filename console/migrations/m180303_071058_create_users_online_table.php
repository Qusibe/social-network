<?php

use yii\db\Migration;

class m180303_071058_create_users_online_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_online', [
            'id_user' => $this->primaryKey(),
            'date' => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_online');
    }
}
