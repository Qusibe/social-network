<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Users_friends extends ActiveRecord 
{    
   
    public function getUsers_info()
   {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id_friend']);
   }
   
   public function getUsers_avatar()
   {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_friend']);
   }
   
}