<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class User_chat extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        
        return $this->render('user_chat');
        
    }
    
}