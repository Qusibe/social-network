<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Groups_wall extends ActiveRecord 
{    
   public function getUsers_avatar()
   {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_user']);
   }
    
   public function getUsers_info()
   {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id_user']);
   }
   
   public function getGroups_wall_like()
   {
        return $this->hasMany(Groups_wall_like::className(), ['id_wall' => 'id']);
   }
}