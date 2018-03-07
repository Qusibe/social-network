<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Users_token;
use frontend\models\RegistrationForm;
use common\models\AuthorizationForm;
use frontend\models\User_activation;
use frontend\models\Restore_password;
use frontend\models\Set_User_Online;
use frontend\models\GetUserPageData;

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
    
    public function actionOut_user()
    {
        if(!Yii::$app->user->isGuest){
            
            $users_token = Users_token::findOne(['id_user' => Yii::$app->user->id]);
         
            $users_token->token = NULL;
           
            $users_token->date = NULL;
           
            $users_token->save();
            
            Yii::$app->user->logout();
                        
        }
        
        return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index']));
    }
    
    public function actionUser_activation()
    {          
       $user_activation = new User_activation(['token' => Yii::$app->request->get('token'), 'id' => Yii::$app->request->get('id')]);
       
       if($user_activation->Activation()){                  
                     
           return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Ваш акаунт активирован']));
           
        }
        
        return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Не удалось активировать акаунт']));
        
    }
    
    public function actionRestore_password()
    {
       $restore_password = new Restore_password(['token' => Yii::$app->request->get('token'), 'id' => Yii::$app->request->get('id'), 'password' => Yii::$app->request->get('password')]);
       
       if($restore_password->Restore()){                  
                     
           return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Ваш пароль изменен']));
           
        }
        
        return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Не удалось изменить пароль']));
        
    }
    
    public function actionUser_page()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
       
        $get_user_data = new GetUserPageData(['id' => Yii::$app->request->get('id')]);
        
        $user_data = $get_user_data->GetData();
        
        return $this->render('user_page', ['user_data' => $user_data]);
   
    }
}
