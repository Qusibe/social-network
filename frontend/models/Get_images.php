<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_images;
use common\models\Users_info;

class Get_images extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Get()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
       $users_images['user'] = Users_info::find()->where('users_info.id_user = :id_user', [':id_user' => $this->id])->joinWith('users_avatar')->one();
        
        
       $users_images['images'] = Users_images::find()->where('id_user = :id_user', [':id_user' => $this->id])->orderBy('id DESC')->asArray()->all();
        
       return $users_images;
    }
}
