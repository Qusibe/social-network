<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Users_info extends ActiveRecord 
{    
   public function getUsers_avatar()
   {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id_user']);
   }
}