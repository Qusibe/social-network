<?php

use yii\db\Migration;

class m180303_071214_create_like_avatar_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('like_avatar', [
            'id' => $this->primaryKey(),
            'id_images' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('like_avatar');
    }
}
