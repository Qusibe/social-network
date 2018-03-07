<?php

namespace common\widgets;

use Yii;
use common\models\Resending_Email_Form;

class Resending_Email extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        
        $form_res = new Resending_Email_Form();
        
         if($form_res->load(Yii::$app->request->post()) && $form_res->Resending()){                  
          
            return $this->render('resending_email', ['form_res' => $form_res, 'message' => 'На ваш Email отправлено письмо']);
          
        }
      
        return $this->render('resending_email', ['form_res' => $form_res, 'message' => '']);
        
    }
    
}