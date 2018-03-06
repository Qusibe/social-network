<?php

use yii\db\Migration;

class m180303_071613_create_users_groups_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_groups', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'name_groups' => $this->string(255)->notNull(),
            'way_images' => $this->string(255)->notNull(),
            'description' => $this->text()
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_groups');
    }
}
