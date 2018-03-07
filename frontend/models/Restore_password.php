<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;

class Restore_password extends Model
{
    public $token;
    public $id; 
    public $password; 
    
    public function rules()
    {
        return [
            
            [['token', 'id', 'password'], 'required'],
            
            ['token', 'trim'],
            ['token', 'string', 'max' => 255],
            
            ['password', 'trim'],
            ['password', 'string', 'min' => 3, 'max' => 255],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/'],
            
            ['id','integer']
           
        ];
    }   
    
    public function Restore()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        if($this->token === 0){
            
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
            
            $user->password = $this->password;
            
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
