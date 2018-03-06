<?php

use yii\db\Migration;

class m180303_071407_create_users_images_comment_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_images_comment', [
            'id' => $this->primaryKey(),
            'id_images' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull(),
            'comment' => $this->string(255)->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_images_comment');
    }
}
