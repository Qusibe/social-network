<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\RegistrationForm;
use common\models\AuthorizationForm;

class SiteController extends Controller
{  
    public function actions()
    {
        $this->view->title = "Social Network";
        
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],            
        ];
    }

    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest ){
                                     
                return $this->redirect(Yii::$app->urlManager->createUrl(['/site/user_page', 'id' => Yii::$app->user->id]));            
               
        }
        
        $registration_form = new RegistrationForm();
        
        if($registration_form->load(Yii::$app->request->post())){
                     
            if($registration_form->Registration()){
            
                return $this->render('index', ['registration_form' => $registration_form, 'index_message' => 'На ваш email отправлено письмо']);
            
            }else{
                
                return $this->render('index', ['registration_form' => $registration_form, 'index_message' => 'Регестрация не удалась, повторите попытку позже']);
                
            }
            
        }
        
        $authorization_form = new AuthorizationForm();
        
        if($authorization_form->load(Yii::$app->request->post()) && $authorization_form->Authorization()){                  
            
                return $this->redirect(Yii::$app->urlManager->createUrl(['/site/user_page', 'id' => Yii::$app->user->id]));
           
        }
        
        return $this->render('index', ['registration_form' => $registration_form, 'authorization_form' => $authorization_form, 'index_message' => '']);
    } 
}
