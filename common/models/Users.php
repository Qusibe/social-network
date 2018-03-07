<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Users extends ActiveRecord implements IdentityInterface
{    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsers_avatar()
    {
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id']);
    }
    
    public function getUsers_info()
    {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id']);
    }
    
    public function getUsers_online()
    {
        return $this->hasOne(Users_online::className(), ['id_user' => 'id']);
    }
      
    public static function findIdentityByAccessToken($token, $type = null)
    {
      
    }
    
    public function getAuthKey()
    {
       
    }

    public function validateAuthKey($authKey)
    {
      
    }
    
    public function generateToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }
}