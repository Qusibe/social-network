<?php

namespace common\models;

use Yii;
use yii\base\Model;

class ChangeResending_Email_Form extends Model
{
    public $email;
    public $login;
    public $password;
   
    public function rules()
    {
        return [
            [['login', 'password', 'email'], 'required', 'message' => 'Пустое поле'],
            
            ['login', 'trim'],                    
            ['login', 'string', 'min' => 3, 'max' => 255], 
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин может состоять только из букв английского алфавита и цифр'],            
            
            ['password', 'trim'],
            ['password', 'string', 'min' => 3, 'max' => 255],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Пароль может состоять только из букв английского алфавита и цифр'],
            
            ['email', 'trim'],            
            ['email', 'email', 'message' => 'Не корекнтный email'],
            ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Пользователь с таким email существует'],
            ['email', 'string', 'max' => 255],
        ];
    }    
    
    public function ChangeResending()
    {             
       if (!$this->validate()) {
            
           return false;
            
       }
        
       $user = Users::findOne(['login' => $this->login]);
       
       if(!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password)){

            return false;

        }
        
        if($user->verified === 1){
                
                return false;
                
            }
       
       $user->email = $this->email;
       $user->token = $user->generateToken();
       
       $user->save();
       
       $trmpUrl = "http://localhost/" . Yii::$app->urlManager->createUrl(['/site/user_activation',
            'id' => Yii::$app->user->id ,'token' => $user->token]);
        
        Yii::$app->mailer->compose()
        ->setFrom('')//email
        ->setTo($this->email)
        ->setSubject('Регестрация акаунта')
        ->setTextBody('Регестрация акаунта')
        ->setHtmlBody('<b>' . $trmpUrl . '</b>')
        ->send();
        
        return true;
                        
    }   
    
}