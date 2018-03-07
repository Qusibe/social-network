<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;
use common\models\Users_avatar;
use common\models\Users_info;
use common\models\Users_online;
use common\models\Users_token;

class RegistrationForm extends Model
{
    public $name;
    public $surname;
    public $login;
    public $password;
    public $email;
        
    public function rules()
    {
        return [
            
          [['name', 'login', 'password', 'email', 'surname'], 'required', 'message' => 'Пустое поле'],
            
          ['name', 'trim'],
          ['name', 'string', 'min' => 2, 'max' => 255],
          ['name', 'match', 'pattern' => '/^[a-zA-Zа-яА-Я]+$/', 'message' => 'Не корректное имя'],
            
          ['surname', 'trim'],
          ['surname', 'string', 'min' => 2, 'max' => 255],
          ['surname', 'match', 'pattern' => '/^[a-zA-Zа-яА-Я]+$/', 'message' => 'Не корректная фамилия'],
            
          ['login', 'trim'],                    
          ['login', 'string', 'min' => 3, 'max' => 255], 
          ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин может состоять только из букв английского алфавита и цифр'],
          ['login', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Этот логин занят'],
            
          ['password', 'trim'],
          ['password', 'string', 'min' => 3, 'max' => 255],
          ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Пароль может состоять только из букв английского алфавита и цифр'],
            
          ['email', 'trim'],
          ['email', 'string', 'max' => 255],
          ['email', 'email', 'message' => 'Не корекнтный email'],
          ['email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'Пользователь с таким email существует'],
                     
        ];
    }   
        
    public function Registration()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $user = new Users();        
        $user->email = $this->email;
        $user->login = $this->login;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->verified = 0;
        $user->token = $user->generateToken();
        $user->status = 0;
        $user->date = '' . date("Y/m/d") . ' ' . date("H:i:s") .'';
        
        try {
        
            if(!$user->save()){

                throw new Exception('Ошибка с базой данных.');

            }
            
        } catch (Exception $e) {
            
            return false;
        
        }
        
        
        
        $user_avatar = new Users_avatar();
        $user_avatar->id_user = $user->id;
        $user_avatar->avatar = "site_content/images/default_avatar.png";
        
        try {
        
            if(!$user_avatar->save()){

                throw new Exception('Ошибка с базой данных.');

            }
            
        } catch (Exception $e) {
            
            $user->delete();
            
            return false;
            
        }
        
        $users_info = new Users_info();
        $users_info->id_user = $user->id;
        $users_info->name = $this->name;
        $users_info->surname = $this->surname;
        
        try {
        
            if(!$users_info->save()){

                throw new Exception('Ошибка с базой данных.');

            }
            
        } catch (Exception $e) {
            
            $user->delete();
            $user_avatar->delete();
            
            return false;
            
        }
        
        $users_online = new Users_online();
        $users_online->id_user = $user->id;
        
        try {
        
            if(!$users_online->save()){

                throw new Exception('Ошибка с базой данных.');

            }
            
        } catch (Exception $e) {
            
            $user->delete();
            $user_avatar->delete();
            $users_info->delete();
            
            return false;
            
        }
        
        $users_token = new Users_token();
        $users_token->id_user = $user->id;
        
        try {
        
            if(!$users_token->save()){

                throw new Exception('Ошибка с базой данных.');

            }
            
        } catch (Exception $e) {
            
            $user->delete();
            $user_avatar->delete();
            $users_info->delete();
            $users_online->delete();
            
            return false;
            
        }
        
        try {
        
            if(!mkdir("users_content/users_audio/". $user->id . "/")){
                
                throw new Exception('Не удалось создать директорию.');
                
            }
            
            if(!mkdir("users_content/users_video/". $user->id . "/")){
                
                throw new Exception('Не удалось создать директорию.');
                
            }
            
            if(!mkdir("users_content/users_images/". $user->id . "/")){
               
                throw new Exception('Не удалось создать директорию.');
                
            }
            
            if(!mkdir("users_content/wall_audio/". $user->id . "/")){
                
                throw new Exception('Не удалось создать директорию.');
                
            }
            
            if(!mkdir("users_content/wall_video/". $user->id . "/")){
                
                throw new Exception('Не удалось создать директорию.');
                
            }
            
            if(!mkdir("users_content/wall_images/". $user->id . "/")){
                
                throw new Exception('Не удалось создать директорию.');
                
            }
            
        } catch (Exception $e) {
            
            $user->delete();
            $user_avatar->delete();
            $users_info->delete();
            $users_online->delete();
            
            rmdir("users_content/users_audio/". $user->id);            
            rmdir("users_content/users_video/". $user->id);            
            rmdir("users_content/users_images/". $user->id);            
            rmdir("users_content/wall_audio/". $user->id);           
            rmdir("users_content/wall_video/". $user->id);
            
            return false;
            
        }
        
        $trmpUrl = "http://localhost/" . Yii::$app->urlManager->createUrl(['/site/user_activation',
            'id' => $user->id ,'token' => $user->token]);
        
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
