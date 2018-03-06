<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Users;

class AuthorizationForm extends Model
{
    public $login;
    public $password;
    public $rememberMe;
    
    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Пустое поле'],
            
            ['login', 'trim'],                    
            ['login', 'string', 'min' => 3, 'max' => 255], 
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин может состоять только из букв английского алфавита и цифр'],
            
            ['password', 'trim'],
            ['password', 'string', 'min' => 3, 'max' => 255],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Пароль может состоять только из букв английского алфавита и цифр'],
            
            ['rememberMe', 'boolean'],
            ['password', 'validateForm']
        ];
    }   
    
     public function validateForm($attribute, $params)
    {
        if (!$this->hasErrors()) {
                                            
            $user = $this->getUser();
          
            if(!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password)){

                return $this->addError($attribute, 'Неверный логин или пароль');

            }
                       
            if($user->verified === 0){
                
                return $this->addError($attribute, 'Ваш акаунт не активирован');
                
            }
          
        }
              
    }
    
    public function Authorization()
    {      
       if ($this->validate()) {
           
           Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
           
           $users_token = Users_token::findOne(['id_user' => Yii::$app->user->id]);
         
           $users_token->token = Yii::$app->security->generateRandomString() . '_' . time();
           
           $users_token->date = '' . date("Y/m/d") . ' ' . date("H:i:s") .'';
           
           $users_token->save();
           
           return true;
            
        }else {
            
            return false;
            
        }
                     
    }
    
    public function getUser()
    {
        return Users::findOne(['login' => $this->login]);
    }
    
}