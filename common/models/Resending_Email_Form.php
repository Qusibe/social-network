<?php

namespace common\models;

use Yii;
use yii\base\Model;

class Resending_Email_Form extends Model
{
    public $login;
    public $password;
   
    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Пустое поле'],
            
            ['login', 'trim'],                    
            ['login', 'string', 'min' => 3, 'max' => 255], 
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин может состоять только из букв английского алфавита и цифр'],
            
            ['password', 'trim'],
            ['password', 'string', 'min' => 3, 'max' => 255],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Пароль может состоять только из букв английского алфавита и цифр']
        ];
    }    
    
    public function Resending()
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
       
       $user->token = $user->generateToken();
       
       $user->save();
       
       $trmpUrl = "http://localhost/" . Yii::$app->urlManager->createUrl(['/site/user_activation',
            'id' => Yii::$app->user->id ,'token' => $user->token]);
        
        Yii::$app->mailer->compose()
        ->setFrom('')//email
        ->setTo($user->email)
        ->setSubject('Регестрация акаунта')
        ->setTextBody('Регестрация акаунта')
        ->setHtmlBody('<b>' . $trmpUrl . '</b>')
        ->send();
        
        return true;
                        
    }   
    
}