<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Groups_wall_comments extends ActiveRecord 
{    
   public function getUsers_avatar()
   {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_user']);
   }
    
   public function getUsers_info()
   {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id_user']);
   }
}