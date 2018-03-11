<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use common\models\Users_token;


class Video_Chat extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        $users_token = Users_token::findOne(['id_user' => Yii::$app->user->id]);
              
        return $this->render('video_chat', ['users_token' => $users_token]);
        
    }
    
}