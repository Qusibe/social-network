<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

class User_activation extends Model
{
    public $token;
    public $id;   
    
    public function rules()
    {
        return [
            
            [['token', 'id'], 'required'],
            
            ['token', 'trim'],
            ['token', 'string', 'max' => 255],
            
            ['id','integer']
        ];
    }   
    
    public function Activation()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $user = Users::find()->where('id = :id', [':id' => $this->id])->one();
        
        if(!$user){
            
            return false;
            
        }
        
        if($user->verified === 1){
            
            return false;
            
        }                
        
        if($user->token === $this->token){
            
            $user->token = 0;
            
            $user->verified = 1;
            
            if(!$user->save()){
                
                return false;
                
            }
            
        }else{
            
            return false;
            
        }
        
        return true;
        
    }
}
