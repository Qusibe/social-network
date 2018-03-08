<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;
use common\models\Users_friends;
use common\models\Participants_groups;

class GetUserPageData extends Model
{  
    public $id;   
    
    public function rules()
    {
        return [   
            ['id','required'],
            ['id','integer']
        ];
    }   
    
    public function GetData()
    {
        if (!$this->validate()) {
            
            return null;
            
        }
        
        $data = array();
        
        if(!Yii::$app->user->isGuest){
                      
            if($this->id == Yii::$app->user->id){

                $data['user_status'] = 'this';                               
                
                $data['button_wall'] = true;

            }else{   
            
                    $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])
                                        ->andWhere( 'id_friend = :id_friend', [':id_friend' => $this->id])->one();

                    if(!$users_friends){

                        $data['user_status'] = 'user';  
                        
                        $data['button_wall'] = false;

                    }elseif($users_friends->status == 0){ //0 друг 1 подана заявка 2 подписчик

                        $data['user_status'] = 'friends'; 
                        
                        $data['button_wall'] = true;

                    }elseif($users_friends->status == 1){

                        $data['user_status'] = 'application'; 
                        
                        $data['button_wall'] = false;

                    }elseif($users_friends->status == 2){

                        $data['user_status'] = 'subscribers';
                        
                        $data['button_wall'] = false;

                    }
            
            }
             
        }else{
            
            $data['user_status'] = 'unauthorized';
            
            $data['button_wall'] = false;
            
        }
        
        $data['user_info'] = Users::find()->where('users.id = :id', [':id' => $this->id])->joinWith('users_avatar')->joinWith('like_avatar')
                ->joinWith('users_online')->joinWith('users_info')->joinWith('users_images')->joinWith('users_friends')
                ->joinWith('users_wall')->joinWith('users_groups')->asArray()->one();
        
        if($data['user_info']['users_online']['date']){
        
            $result_date = (int)((strtotime('' . date("Y/m/d") . ' ' . date("H:i:s") .'') - strtotime($data['user_info']['users_online']['date'])) / 60);

            if($result_date > 15){

                $data['online'] = "Offline";

            }else{

                $data['online'] = "Online";

            }
        
        }else{
            
            $data['online'] = "Offline";
            
        }
        
        if(count($data['user_info']['users_groups']) < 4){
        
            $data['participants_groups'] = Participants_groups::find()->where('participants_groups.id_user = :id_user', [':id_user' => $this->id])->andWhere('status = :status', [':status' => 0])->joinWith('users_groups')->orderBy('id DESC')->limit(4 - count($data['user_info']['users_groups']))->asArray()->all(); 
        
        }
        
        return $data;
    }
}
