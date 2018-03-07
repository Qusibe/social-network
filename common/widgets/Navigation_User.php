<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\AuthorizationForm;
use frontend\models\RegistrationForm;
use common\models\Users_message;

class Navigation_User extends \yii\bootstrap\Widget
{
    
    public function run()
    {     
            $auth_form = new AuthorizationForm();

            if($auth_form->load(Yii::$app->request->post()) && $auth_form->Authorization()){                  


            }

            $reg_form = new RegistrationForm();

            if($reg_form->load(Yii::$app->request->post())){

                if($reg_form->Registration()){


                }else{



                }

            }

            $size_message = 0;
            
            if(!Yii::$app->user->isGuest){
            
                $size_message = Users_message::find()->where('id_friend = :id_friend', [':id_friend' => Yii::$app->user->id])->andWhere('status = :status', [':status' => 1])->count();
            
            }

            return $this->render('navigation_user',['auth_form' => $auth_form, 'reg_form' => $reg_form, 'size_message' => $size_message]);
        
                     
    }
    
}