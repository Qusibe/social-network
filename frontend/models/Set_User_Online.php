<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_online;

class Set_User_Online extends Model
{     
   
    public function SetDate()
    {
        $users_online = Users_online::findOne(['id_user' => Yii::$app->user->id]);

        $users_online->date = '' . date("Y/m/d") . ' ' . date("H:i:s") .'';

        $users_online->save();
    }
}
