<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users;
use common\models\Users_avatar;
use common\models\Users_info;
use common\models\Users_friends;
use common\models\Users_time_message;
use common\models\Users_message;
use frontend\models\Set_User_Online;

class User_chat extends Model
{  
    public $id;
    public $message;
    public $size;
    
    public function rules()
    {
        return [  
            ['id', 'required'],
            ['id','integer'],
            
            ['size', 'required'],
            ['size','integer'],
            
            ['message', 'string', 'max' => 255]       
        ];
    }   
    
    public function GetData()
    {
        if (!$this->validate()) {
            
            return null;
            
        }
              
        $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])
                                        ->andWhere( 'id_friend = :id_friend', [':id_friend' => $this->id])->one();
        
        if(!$users_friends && $users_friends->status != 0){
            
            return null;
            
        }
       
        if(empty($this->message)){
            
            if(!Yii::$app->user->isGuest ){
            
                $set_user_online = new Set_User_Online();

                $set_user_online->SetDate();

            }
            
            $data = array();
            
            if($this->size == 0){
                
                $data['user_name'] = Users_info::find()->where(['id_user' => $this->id])->asArray()->one();
                
                $data['user_avatar'] = Users_avatar::find()->where(['id_user' => $this->id])->asArray()->one();
                
            }
            
            Users_message::UpdateAll(['status' => 0], 'id_user = ' . $this->id . ' AND id_friend = ' . Yii::$app->user->id . ' AND status = 1');
            
            $size = Users_message::find()->where(['IN','id_user', [Yii::$app->user->id, $this->id]])
                                            ->andWhere(['IN','id_friend', [Yii::$app->user->id, $this->id]])->count();
            
            $data['chat_data'] = Users_message::find()->where(['IN','users_message.id_user', [Yii::$app->user->id, $this->id]])
                                            ->andWhere(['IN','users_message.id_friend', [Yii::$app->user->id, $this->id]])
                                                ->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->limit($size - $this->size)->asArray()->all();
            
            
            return $data;
        }
        
        if(!empty($this->message)){
            
            $usermessage = new Users_message();

            $usermessage->id_user = Yii::$app->user->id;
            $usermessage->id_friend = $this->id;
            $usermessage->message = $this->message;
            $usermessage->status = 1;

            $usermessage->save();
            
            $usertimemessage = Users_time_message::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere('id_friend = :id_friend', [':id_friend' => $this->id])->one();
           
            $usertimemessage->date = '' . date("Y/m/d") . ' ' . date("H:i:s") .'';

            $usertimemessage->save();
            
            return null;
            
        }
       
        return null;
    }
}

