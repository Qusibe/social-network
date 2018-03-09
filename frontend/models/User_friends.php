<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_friends;

class User_friends extends Model
{  
    public $id;   
    
    public function rules()
    {
        return [          
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function GetData()
    {
        if (!$this->validate()) {
            
            return null;
            
        }
               
        
        $data['users_friends'] = Users_friends::find()->where('users_friends.id_user = :id_user', [':id_user' => $this->id])
                ->andWhere( 'users_friends.status = :status', [':status' => 0])
                ->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->asArray()->all();
       
        return $data;
    }
}
