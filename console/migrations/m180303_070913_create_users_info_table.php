<?php

use yii\db\Migration;

class m180303_070913_create_users_info_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('users_info', [
            'id_user' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'surname' => $this->string(255)->notNull(),
            'quote' => $this->string(255),
            'birthday' => $this->string(255),
            'hometown' => $this->string(255),
            'gender' => $this->string(255),
            'maritalstatus' => $this->string(255),
            'city' => $this->string(255),
            'activity' => $this->string(255),
            'interests' => $this->string(255),
            'favoritemusic' => $this->string(255),
            'highschool' => $this->string(255),
            'faculty' => $this->string(255),
            'formoftraining' => $this->string(255),
            'status' => $this->string(255),
            'schools' => $this->string(255),           
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function safeDown()
    {
        $this->dropTable('users_info');
    }
}
