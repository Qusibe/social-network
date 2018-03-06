<?php

use yii\db\Migration;

class m180303_070837_create_users_avatar_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_avatar', [
            'id_user' => $this->primaryKey(),
            'avatar' => $this->string(255),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_avatar');
    }
}
