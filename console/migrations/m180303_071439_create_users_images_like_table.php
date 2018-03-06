<?php

use yii\db\Migration;

class m180303_071439_create_users_images_like_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_images_like', [
            'id' => $this->primaryKey(),
            'id_images' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_images_like');
    }
}
