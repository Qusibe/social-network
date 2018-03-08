<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Participants_groups extends ActiveRecord 
{    
   public function getUsers_avatar()
   {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_user']);
   }
    
   public function getUsers_info()
   {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id_user']);
   }
   
   public function getUsers_groups()
   {
        return $this->hasOne(Users_groups::className(), ['id' => 'id_groups']);
   }
}