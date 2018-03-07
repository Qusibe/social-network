<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Restore_Password_Form;

class Restore_Password extends \yii\bootstrap\Widget
{
    
    public function run()
    {
        
        $form = new Restore_Password_Form();  
        
        if($form->load(Yii::$app->request->post()) && $form->Restore()){                  
            
            return '<script type="text/javascript"> 
               
                    alert("На ваш email отправлено письмо")
              
                    </script>';
            
        }
      
        return $this->render('restore_password', ['form' => $form]);
        
    }
    
}