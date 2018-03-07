<?php

namespace common\models;

use Yii;
use yii\base\Model;

class Restore_Password_Form extends Model
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
            ['email', 'string', 'max' => 255],
        ];
    }   
    
     public function Restore()
    {                 
            if (!$this->validate()) {
            
                return false;
            
            }
         
            $user = $this->getUser();
            
            if(!$user){
                
                return $this->addError($attribute, 'Такого логина не существует');
                
            }
            
            if($user->email !== $this->email){
                
                return $this->addError($attribute, 'У этого логина нет такого email');
                
            }
            
            
            $user->token = $user->generateToken();
            
            $user->verified = 0;
            
            $user->save();
            
            
            $trmpUrl = "http://localhost/" . Yii::$app->urlManager->createUrl(['/site/restore_password',
            'id' => $user->id , 'password' => Yii::$app->getSecurity()->generatePasswordHash($this->password),'token' => $user->token]);
        
            Yii::$app->mailer->compose()
            ->setFrom('')//email
            ->setTo($this->email)
            ->setSubject('Востановление пароля')
            ->setTextBody('Востановление пароля')
            ->setHtmlBody('<b>' . $trmpUrl . '</b>')
            ->send();     
        
            return true;
            
    }
    
    public function getUser()
    {
        return Users::findOne(['login' => $this->login]);
    }
    
}