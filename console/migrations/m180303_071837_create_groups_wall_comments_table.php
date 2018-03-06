<?php

use yii\db\Migration;

class m180303_071837_create_groups_wall_comments_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('groups_wall_comments', [
            'id' => $this->primaryKey(),
            'id_wall' => $this->integer()->notNull(),
            'id_user' => $this->integer()->notNull(),
            'comment' => $this->string(255)->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('groups_wall_comments');
    }
}
