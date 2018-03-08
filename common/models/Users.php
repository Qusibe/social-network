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
        return $this->hasOne(Users_avatar::className(), ['id_user' => 'id'])->from(['u3' => Users_avatar::tableName()]);
    }
    
    public function getUsers_info()
    {
        return $this->hasOne(Users_info::className(), ['id_user' => 'id'])->from(['u2' => Users_info::tableName()]);
    }
    
    public function getUsers_online()
    {
        return $this->hasOne(Users_online::className(), ['id_user' => 'id']);
    }
    
    public function getLike_avatar()
    {
        return $this->hasMany(Like_avatar::className(), ['id_images' => 'id']);
    }
    
    public function getUsers_images()
    {
        return $this->hasMany(Users_images::className(), ['id_user' => 'id'])->orderBy('id DESC')->limit(4);
    }
      
    public function getUsers_friends()
    {
        return $this->hasMany(Users_friends::className(), ['id_user' => 'id'])->where('users_friends.status = :status', [':status' => 0])
                ->joinWith('users_avatar')->joinWith('users_info')->orderBy('id DESC')->limit(4);
    }
    
    public function getUsers_wall()
    {
        return $this->hasMany(Users_wall::className(), ['id_user' => 'id'])->joinWith('users_wall_like')
                ->joinWith('users_avatar')->joinWith('users_info')->orderBy('id DESC');
    }
    
    public function getUsers_groups()
    {
        return $this->hasMany(Users_groups::className(), ['id_user' => 'id'])->orderBy('id DESC')->limit(4);
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