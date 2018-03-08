<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Users_wall extends ActiveRecord 
{    
    public function getUsers_avatar()
    {
         return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_friend'])->from(['u4' => Users_avatar::tableName()]);
    }

    public function getUsers_info()
    {
         return $this->hasOne(Users_info::className(), ['id_user' => 'id_friend'])->from(['u5' => Users_info::tableName()]);
    }

    public function getUsers_wall_like()
    {
         return $this->hasMany(Users_wall_like::className(), ['id_wall' => 'id']);
    }
}