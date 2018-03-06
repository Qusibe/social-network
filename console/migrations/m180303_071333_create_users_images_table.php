<?php

use yii\db\Migration;

class m180303_071333_create_users_images_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_images', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'way_images' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_images');
    }
}
