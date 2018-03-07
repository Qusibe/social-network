<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ChangeResending_Email_Form;

class ChangeResending_Email extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        
        $form_chres = new ChangeResending_Email_Form();
        
         if($form_chres->load(Yii::$app->request->post()) && $form_chres->ChangeResending()){                  
          
            return $this->render('changeresending_email', ['form_chres' => $form_chres, 'message' => 'На ваш новый Email отправлено письмо']);
          
        }
      
        return $this->render('changeresending_email', ['form_chres' => $form_chres, 'message' => '']);
        
    }
    
}