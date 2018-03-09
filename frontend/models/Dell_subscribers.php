<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_friends;
use common\models\Users_time_message;

class Dell_subscribers extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Dell()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $this_users = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere( 'id_friend = :id_friend', [':id_friend' => $this->id])->one();
        
        if(!$this_users){
                       
            return false;
            
        }
        
        if($this_users->status == 2){
            
            $subscribers = Users_friends::find()->where('id_user = :id_user', [':id_user' => $this->id])->andWhere( 'id_friend = :id_friend', [':id_friend' => Yii::$app->user->id])->one();       
            
            $this_users->delete();
            
            $subscribers->delete();
            
            $usertimemessage = Users_time_message::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere('id_friend = :id_friend', [':id_friend' => $this->id])->one();
           
            $friendstimemessage = Users_time_message::find()->where('id_user = :id_user', [':id_user' => $this->id])->andWhere('id_friend = :id_friend', [':id_friend' => Yii::$app->user->id])->one();
           
            $usertimemessage->delete();
            
            $friendstimemessage->delete();
                    
            return true;
            
        }
        
        return false;
        
    }
}