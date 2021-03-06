<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Users_token;
use frontend\models\RegistrationForm;
use common\models\AuthorizationForm;
use frontend\models\User_activation;
use frontend\models\Restore_password;
use frontend\models\Set_User_Online;
use frontend\models\GetUserPageData;
use frontend\models\Editing_Form;
use frontend\models\Like_user_avatar;
use frontend\models\Comment_avatar_user;
use frontend\models\User_Wall_Form;
use frontend\models\Dell_user_wall;
use frontend\models\Like_user_wall;
use frontend\models\Add_friends;
use frontend\models\Dell_application;
use frontend\models\Dell_friends;
use frontend\models\Dell_subscribers;
use frontend\models\Add_subscribers;
use frontend\models\User_friends;
use frontend\models\User_chat;
use frontend\models\List_message;
use frontend\models\Add_images;
use frontend\models\Get_images;
use frontend\models\Comment_images_user;
use frontend\models\Del_user_images;
use frontend\models\Like_user_images;
use frontend\models\Create_groups;
use frontend\models\Get_list_groups;
use frontend\models\GetGroupsPageData;
use frontend\models\Groups_Wall_Form;
use frontend\models\Request_entry_groups;
use frontend\models\Unsubscription_groups;
use frontend\models\Leave_groups;
use frontend\models\Add_participants;
use frontend\models\Like_groups_wall;
use frontend\models\Comment_wall_groups;
use frontend\models\List_participants_groups;
use frontend\models\Del_user_groups;
use frontend\models\Dell_groups_wall;
use frontend\models\Editing_Groups_Form;
use frontend\models\Site_search;

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
        
        $user_wall_form = new User_Wall_Form();
        
        if($user_wall_form->load(Yii::$app->request->post())){
            
            if($user_wall_form->validate()){
            
            $user_wall_form->user_file = UploadedFile::getInstances($user_wall_form, 'user_file');
         
            $user_wall_form->upload();
           
            }
            
        }
       
        $get_user_data = new GetUserPageData(['id' => Yii::$app->request->get('id')]);
        
        $user_data = $get_user_data->GetData();
        
        return $this->render('user_page', ['user_data' => $user_data, 'user_wall_form' => $user_wall_form]);
   
    }
    
    public function actionEditing()
    {
        if(Yii::$app->user->isGuest){
            
            return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Необходимо авторизоваться']));
                        
        }
       
        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();
             
        $edit_form = new Editing_Form();
        
        if($edit_form->load(Yii::$app->request->post())){                  
                     
            $edit_form->file = UploadedFile::getInstance($edit_form, 'file');

            $edit_form->Editing();
           
            return $this->redirect(Yii::$app->urlManager->createUrl(['/site/user_page', 'id' => Yii::$app->user->id]));  
          
        }
         
        return $this->render('editing', ['edit_form' => $edit_form]);
               
    }
    
    public function actionLike_user_avatar()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $like_user_avatar = new Like_user_avatar(['id' => Yii::$app->request->post('id')]);
        
        $data = $like_user_avatar->Like();
       
        return json_encode($data);
    }
    
    public function actionComment_avatar_user()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        $comment_avatar_user = new Comment_avatar_user(['id' => Yii::$app->request->post('id'), 'comment' => Yii::$app->request->post('comment'), 'size' => Yii::$app->request->post('size')]);
        
        $data = $comment_avatar_user->Comment();
        
        return json_encode($data);               
    }
    
    public function actionDell_user_wall()
    {  
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $set_user_online = new Set_User_Online();
            
        $set_user_online->SetDate();
        
        $dell_user_wall = new Dell_user_wall(['id_wall' => Yii::$app->request->post('id_wall')]);
        
        $data = $dell_user_wall->Delete();
        
        return json_encode($data);               
    }
    
    public function actionLike_user_wall()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $set_user_online = new Set_User_Online();
            
        $set_user_online->SetDate();                   
       
        $like_user_wall = new Like_user_wall(['id' => Yii::$app->request->post('id')]);
        
        $data = $like_user_wall->Like();
       
        return json_encode($data);
    }
    
    public function actionAdd_friends()
    {
        if(Yii::$app->user->isGuest){
            
            return json_encode(false);
                        
        }
     
        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $user_friends = new Add_friends(['id' => Yii::$app->request->post('id')]);
        
        $data = $user_friends->Add();
       
        return json_encode($data);
    }
    
    public function actionDell_application()
    {
        if(Yii::$app->user->isGuest){
            
            return json_encode(false);
                        
        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $dell_application = new Dell_application(['id' => Yii::$app->request->post('id')]);
        
        $data = $dell_application->Dell();
       
        return json_encode($data);
    }
    
    public function actionDell_friends()
    {
        if(Yii::$app->user->isGuest){
            
            return json_encode(false);
                        
        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $dell_friends = new Dell_friends(['id' => Yii::$app->request->post('id')]);
        
        $data = $dell_friends->Dell();
       
        return json_encode($data);
    }
    
    public function actionDell_subscribers()
    {
        if(Yii::$app->user->isGuest){
            
            return json_encode(false);
                        
        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $dell_subscribers = new Dell_subscribers(['id' => Yii::$app->request->post('id')]);
        
        $data = $dell_subscribers->Dell();
       
        return json_encode($data);
    }
    
    public function actionAdd_subscribers()
    {
        if(Yii::$app->user->isGuest){
            
            return json_encode(false);
                        
        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $user_subscribers = new Add_subscribers(['id' => Yii::$app->request->post('id')]);
        
        $data = $user_subscribers->Add();
       
        return json_encode($data);
    }
    
    public function actionUser_friends()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        $user_friends = new User_friends(['id' => Yii::$app->request->get('id')]);
        
        $friends_data = $user_friends->GetData();
        
        return $this->render('user_friends', ['friends_data' => $friends_data]);       
    }
    
    public function actionUser_chat()
    {
        if(Yii::$app->user->isGuest){

            return;

        }
        
        $user_chat = new User_chat(['id' => Yii::$app->request->post('id'), 'message' => Yii::$app->request->post('message'), 'size' => Yii::$app->request->post('size')]);
        
        $data = $user_chat->GetData();
       
        return json_encode($data);        
    }
    
    public function actionList_message()
    {
        if(Yii::$app->user->isGuest){

            return;

        }
       
        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $list_message = new List_message();
        
        $list_data = $list_message->GetData();
        
        return $this->render('list_message', ['list_data' => $list_data]);
    }
    
    public function actionView_images()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        $add_images = new Add_images();
        
        if($add_images->load(Yii::$app->request->post())){                  
            
                $add_images->imageFiles = UploadedFile::getInstances($add_images, 'imageFiles');
           
                $add_images->Add();
                
        }
        
        $get_images = new Get_images(['id' => Yii::$app->request->get('id')]);
        
        $data_img = $get_images->Get();
        
        return $this->render('view_images', ['add_images' => $add_images, 'data_img' => $data_img]);
    }
    
    public function actionComment_images_user()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        $comment_images_user = new Comment_images_user(['id' => Yii::$app->request->post('id'), 'comment' => Yii::$app->request->post('comment'), 'size' => Yii::$app->request->post('size')]);
        
        $data = $comment_images_user->Comment();
        
        return json_encode($data);               
    }
    
    public function actionDel_user_images()
    {       
        if(Yii::$app->user->isGuest){

            return false;

        }
        
        $set_user_online = new Set_User_Online();
            
        $set_user_online->SetDate();
        
        $del_user_images = new Del_user_images(['id' => Yii::$app->request->post('id')]);
        
        $data = $del_user_images->Delete();
        
        return json_encode($data);               
    }
    
    public function actionLike_user_images()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $like_user_images = new Like_user_images(['id' => Yii::$app->request->post('id')]);
        
        $data = $like_user_images->Like();
       
        return json_encode($data);
    }
    
    public function actionList_groups()
    {
        if(!Yii::$app->user->isGuest){

            $set_user_online = new Set_User_Online();

            $set_user_online->SetDate();

        }
        
        $create_groups = new Create_groups();
        
        if($create_groups->load(Yii::$app->request->post())){                  
                     
            if($create_groups->validate()){
            
                $create_groups->images_groups = UploadedFile::getInstance($create_groups, 'images_groups');

                $create_groups->Create();

            }
                                 
        }
        
        $get_list_groups = new Get_list_groups(['id' => Yii::$app->request->get('id')]);
       
        $list_groups = $get_list_groups->Get();                                      
        
        return $this->render('list_groups',['create_groups' => $create_groups, 'list_groups' => $list_groups]);
    }
    
    public function actionGroups_page()
    {
        $groups_wall_form = new Groups_Wall_Form();
        
        if($groups_wall_form->load(Yii::$app->request->post())){
            
            $groups_wall_form->groups_file = UploadedFile::getInstances($groups_wall_form, 'groups_file');
         
            $groups_wall_form->upload();
           
        }
        
        $get_groups_page_data = new GetGroupsPageData(['id' => Yii::$app->request->get('id')]);
       
        $data_groups = $get_groups_page_data->Get();                                      
        
        return $this->render('groups_page', ['data_groups' => $data_groups, 'groups_wall_form' => $groups_wall_form]);
    }
    
    public function actionRequest_entry_groups()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $request_entry_groups = new Request_entry_groups(['id' => Yii::$app->request->post('id')]);
       
        $data = $request_entry_groups->Request();                                      
        
        return json_encode($data);
    }
    
    public function actionUnsubscription_groups()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $unsubscription_groups = new Unsubscription_groups(['id' => Yii::$app->request->post('id')]);
       
        $data = $unsubscription_groups->Unsubscription();                                      
        
        return json_encode($data);
    }
    
    public function actionLeave_groups()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $leave_groups = new Leave_groups(['id' => Yii::$app->request->post('id')]);
       
        $data = $leave_groups->Leave();                                      
        
        return json_encode($data);
    }
    
    public function actionAdd_participants()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $add_participants = new Add_participants(['id_groups' => Yii::$app->request->post('id_groups'), 'id_user' => Yii::$app->request->post('id_user')]);
       
        $data = $add_participants->Add();                                      
        
        return json_encode($data);
    }
    
    public function actionLike_groups_wall()
    {
        if(Yii::$app->user->isGuest){

            return json_encode(false);

        }
        
        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $like_groups_wall = new Like_groups_wall(['id' => Yii::$app->request->post('id')]);
        
        $data = $like_groups_wall->Like();
       
        return json_encode($data);
    }
    
    public function actionComment_wall_groups()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        $comment_wall_groups = new Comment_wall_groups(['id' => Yii::$app->request->post('id'), 'id_groups' => Yii::$app->request->post('id_groups'), 'comment' => Yii::$app->request->post('comment'), 'size' => Yii::$app->request->post('size')]);
        
        $data = $comment_wall_groups->Comment();
        
        return json_encode($data);               
    }
    
    public function actionList_participants_groups()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
       
        $list_participants_groups = new List_participants_groups(['id' => Yii::$app->request->get('id')]);
       
        $list_participants = $list_participants_groups->Get();                                      
        
        return $this->render('list_participants_groups',['list_participants' => $list_participants]);
    }
    
    public function actionDel_user_groups()
    {
        if(!Yii::$app->user->isGuest ){
            
            $set_user_online = new Set_User_Online();
            
            $set_user_online->SetDate();
            
        }
        
        if(Yii::$app->user->isGuest){

            return false;

        }
        
        $del_user_groups = new Del_user_groups(['id_user' => Yii::$app->request->post('id_user'), 'id_groups' => Yii::$app->request->post('id_groups')]);
        
        $data = $del_user_groups->Delete();
        
        return json_encode($data);               
    }
    
    public function actionDell_groups_wall()
    {     
        if(Yii::$app->user->isGuest){

            return false;

        }
        
        $set_user_online = new Set_User_Online();
            
        $set_user_online->SetDate();
        
        $dell_groups_wall = new Dell_groups_wall(['id_wall' => Yii::$app->request->post('id_wall')]);
        
        $data = $dell_groups_wall->Delete();
        
        return json_encode($data);               
    }
    
    public function actionEditing_groups()
    {
        if(Yii::$app->user->isGuest){
            
            return $this->redirect(Yii::$app->urlManager->createUrl(['/site/index', 'message' => 'Необходимо авторизоваться']));
                        
        }

        $set_user_online = new Set_User_Online();

        $set_user_online->SetDate();

        $edit_groups_form = new Editing_Groups_Form();
        
        if($edit_groups_form->load(Yii::$app->request->post())){                  
                     
            if($edit_groups_form->validate()){
            
                $edit_groups_form->file = UploadedFile::getInstance($edit_groups_form, 'file');

                $edit_groups_form->Editing();

                return $this->redirect(Yii::$app->urlManager->createUrl(['/site/groups_page', 'id' => Yii::$app->request->get('id')]));  
          
            }
            
        }
         
        return $this->render('editing_groups', ['edit_groups_form' => $edit_groups_form]);       
        
    }
    
    public function actionSite_search()
    {      
        $site_search = new Site_search(['str_search' => Yii::$app->request->get('search')]);
        
        $search = $site_search->Search();
              
        return $this->render('site_search', ['search' => $search]);
        
    }
}
