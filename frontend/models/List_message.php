<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_time_message;

class List_message extends Model
{     
    public function GetData()
    {
      
        $data = Users_time_message::find()->where('users_time_message.id_friend = :id_friend', [':id_friend' => Yii::$app->user->id])
                            ->joinWith('users_info')->joinWith('users_avatar')->joinWith('users_message')->orderBy('date DESC')->asArray()->all();
        
        return $data;
    }
}