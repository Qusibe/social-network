<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_friends;
use common\models\Users_time_message;

class Add_friends extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Add()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere( 'id_friend = :id_friend', [':id_friend' => $this->id])->one();
        
        if(!$users_friends){
            
            $addthis = new Users_friends();
            $addthis->id_user = Yii::$app->user->id;
            $addthis->id_friend = $this->id;
            $addthis->status = 1;
            $addthis->save();

            $addfriends = new Users_friends();
            $addfriends->id_user = $this->id;
            $addfriends->id_friend = Yii::$app->user->id;
            $addfriends->status = 2;
            $addfriends->save();
            
            $thistimemessage = new Users_time_message();
            $thistimemessage->id_user = Yii::$app->user->id;
            $thistimemessage->id_friend = $this->id;
            $thistimemessage->save();

            $friendstimemessage1 = new Users_time_message();
            $friendstimemessage1->id_user = $this->id;
            $friendstimemessage1->id_friend = Yii::$app->user->id;
            $friendstimemessage1->save();
            
            return true;
            
        }else{
            
            return false;
            
        }
        
    }
}
