<?php

use yii\db\Migration;

class m180303_071753_create_groups_wall_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('groups_wall', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_groups' => $this->integer()->notNull(),
            'message' => $this->string(255),
            'way_file' => $this->string(255),
            'format' => $this->string(255)
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('groups_wall');
    }
}
