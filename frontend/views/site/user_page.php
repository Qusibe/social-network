<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\User_PageAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

Html::csrfMetaTags();

User_PageAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">

      
</script>

<div id="content_page_user" class="container">
    
    <div id="user_content_left">
        
        <div id="user_avatar">
            
            <div onclick='JumpAvatar()' style='cursor: pointer; width: 100%; height: 300px; background: url("<?= $user_data['user_info']['users_avatar']['avatar'] ?>") no-repeat center/cover;'></div>              
            
           <p id="number_like" style='color: #3C578C; float: right; margin:8px 5px 5px 5px;'><?= 0 ?></p>
            
            <img onclick = 'LikeAvatar()' style='margin-bottom: 5px; margin-top: 5px; cursor: pointer; float: right;' src="<?=  Url::to("@web/site_content/images/Like.jpg") ?>"  HEIGHT="20" WIDTH="20"  />               
            
            <?php if($user_data['user_status'] === 'this'){ ?>
            
                <button type='submit' class='btn btn-success btn-block' data-dismiss='modal' data-toggle='modal' data-target='#ModalSubscribers' style="margin-top: 10px;">Подписчики: <?= 0 ?></button>
            
            <?php } ?>
                
            <?php if($user_data['user_status'] === 'friends'){ ?>
               
                <img onclick='DellFriends()' title="Удалить из друзей?" style='margin-right: 10px; margin-bottom: 5px; margin-top: 5px; cursor: pointer; float: right;' src="<?=  Url::to("@web/site_content/images/Delete.jpg") ?>"  HEIGHT="20" WIDTH="20"  />            
                
                <button onclick='JumpUserChat()'  type='submit' class='btn btn-primary btn-block' data-dismiss='modal' data-toggle='modal' data-target='#modal_user_chat' style="margin-top: 10px;">Написать сообщение</button>
                
                <button onclick='JumpVideoChat()' type='submit' class='btn btn-info btn-block' style="margin-top: 10px;">Позвонить</button>
                          
            <?php } ?>
            
            <?php if($user_data['user_status'] === 'subscribers'){ ?>
            
                <button onclick='AddSubscribers()' type='submit' class='btn btn-success btn-block' style="margin-top: 10px;">Подтвердить</button>
                
                <button onclick='DellSubscribers()' type='submit' class='btn btn-primary btn-block' style="margin-top: 10px;">Отклонить</button>
            
            <?php } ?>
                
            <?php if($user_data['user_status'] === 'application'){ ?>
                           
                <button onclick='DellApplication()' type='submit' class='btn btn-success btn-block' style="margin-top: 10px;">Отклонить</button>
            
            <?php } ?>
                
            <?php if($user_data['user_status'] === 'user'){ ?>
            
                <button onclick='AddFriend()' type='submit' class='btn btn-success btn-block' style="margin-top: 10px;">Добавить в друзья</button>
            
            <?php } ?>
                
            <?php if($user_data['user_status'] === 'unauthorized'){ ?>
            
                <p align="center" style="clear: both; margin-top: 10px;">Войдите чтобы отправить этому пользователю сообщение.</p>
                
            <?php } ?>
            
        </div>
      
        <div id="user_friends">
                      
            <p align="center" style="margin-top: 10px; margin-bottom: 0px;"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/user_friends', 'id' => Yii::$app->request->get('id')]); ?>">Друзья</a></p>
            
           
            
        </div>
        
        <div id="user_groups">
            
            <p align="center" style="margin-top: 10px; margin-bottom: 0px;"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/list_groups', 'id' => Yii::$app->request->get('id')]); ?>">Группы</a></p>
            
          
        </div>
                
    </div>
  
    <div id="user_content_right">
        
        <div id="user_info">
            
            <h4 style="color:#269abc;"><?= $user_data['user_info']['users_info']['name'] ?> &nbsp <?= $user_data['user_info']['users_info']['surname'] ?><p style="color: #9acfea; float: right;"><?= $user_data['online'] ?></p></h4>                      
           
            <?php if(!empty($user_data['basic_info']['users_info']['quote'])){ ?>
            
                <p style="color:#269abc;"><?= $user_data['basic_info']['users_info']['quote'] ?></p>                      
            
            <?php } ?>
                       
            <hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />          
            
            <?php if(!empty($user_data['basic_info']['users_info']['birthday'])){ ?>
            
                <p style="clear: both;color: #9acfea;">День рождения: <span style="margin-left: 40px; color:#269abc;"><?= $user_data['basic_info']['users_info']['birthday'] ?></span></p>
            
            <?php } ?>
            
            <?php if(!empty($user_data['basic_info']['users_info']['gender'])){ ?>                       
                
                <p style="color:#9acfea;">Пол: <span style="margin-left: 115px; color:#269abc;"><?= $user_data['basic_info']['users_info']['gender'] ?></span> </p>
            
            <?php } ?>
            
            <?php if(!empty($user_data['basic_info']['users_info']['hometown'])){ ?>
            
                <p style="color:#9acfea;">Родной город: <span style="margin-left: 53px; color:#269abc;"><?= $user_data['basic_info']['users_info']['hometown'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Контактная информация &nbsp&nbsp</p> <hr style=" margin-top: 9px; width: calc(100% - 175px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
                
            <?php if(!empty($user_data['basic_info']['users_info']['city'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Город: <span style="margin-left: 105px; color:#269abc;"><?= $user_data['basic_info']['users_info']['city'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Личная информация &nbsp&nbsp</p> <hr style=" margin-top: 9px; width:  calc(100% - 150px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
                   
            <?php if(!empty($user_data['basic_info']['users_info']['activity'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Деятельность: <span style="margin-left: 50px; color:#269abc;"><?= $user_data['basic_info']['users_info']['activity'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['interests'])){ ?>
            
                <p style="color:#9acfea;">Интересы:<span style="margin-left: 80px; color:#269abc;"><?= $user_data['basic_info']['users_info']['interests'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['favoritemusic'])){ ?>
            
                <p style="color:#9acfea;">Любимая музыка:<span style="margin-left: 33px; color:#269abc;"><?= $user_data['basic_info']['users_info']['favoritemusic'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Образование &nbsp&nbsp</p> <hr style=" margin-top: 9px; width:  calc(100% - 100px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
              
            <?php if(!empty($user_data['basic_info']['users_info']['highschool'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Вуз:<span style="margin-left: 125px; color:#269abc;"><?= $user_data['basic_info']['users_info']['highschool'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['faculty'])){ ?>
            
                <p style="color:#9acfea;">Факультет: <span style="margin-left: 75px; color:#269abc;"><?= $user_data['basic_info']['users_info']['faculty'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['formoftraining'])){ ?>
            
                <p style="color:#9acfea;">Форма обучения:<span style="margin-left: 38px; color:#269abc;"><?= $user_data['basic_info']['users_info']['formoftraining'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['status'])){ ?>
            
                <p style="color:#9acfea;">Статус:<span style="margin-left: 102px; color:#269abc;"><?= $user_data['basic_info']['users_info']['status'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['basic_info']['users_info']['schools'])){ ?>
            
                <p style="color:#9acfea;">Школа:<span style="margin-left: 104px; color:#269abc;"><?= $user_data['basic_info']['users_info']['schools'] ?></span> </p>
            
            <?php } ?>
            
        </div>
       
        <ul id="user_images">
                 
            <p align="center" style=""><a  href="<?= Yii::$app->urlManager->createUrl(['/site/view_images', 'id' => Yii::$app->request->get('id')]); ?>">Фотографии пользователя</a></p>            
            
           
            
        </ul>
        
        <script language="javascript" type="text/javascript">
        
        
        
        </script>
        
        <div id="user_wall">
           
            <?php  if($user_data['button_wall']){ ?>
            
                <button type='submit' id="button_user_wall" class='btn btn-default btn-block'  data-dismiss='modal' data-toggle='modal' data-target='#modal_user_wall' >Оставить запись</button>
            
            <?php }  ?>
            
        </div>
        
    </div>
    
</div>

<div id='ModalSubscribers' class='modal fade'>

        <div class='modal-dialog'>

            <div class='modal-content'>

                <div class='modal-header'>

                    <button class='close' data-dismiss='modal'>x</button>

                    <h4 class='modal-title'>Подписчики</h4>

                </div>

                <br />

                <div class='media-body' style="overflow-y: auto;  padding: 20px; ">                                             

                    

                </div>    

                <br />

                <div class='modal-footer'>

                </div>

            </div>

        </div>

</div>

<div id='modal_user_wall' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Запись на стене</h4>

            </div>

            <br />

            <div class='media-body' style="padding: 20px; ">   

             
            </div>    

            <br />

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>

<script language="javascript" type="text/javascript">
        
     
</script>

<div id="preview_avatar">
    
    <div id="content_avatar">
        
        <div id="user_show_avatar" style="width: 75%; height: 100%; float: left;">
            
         
        </div>
        
       <div id="user_avatar_comments" style="padding: 5px; width: 25%; height: 100%; float: left; background-color: white;">
                        
            <div id="user_set_avatar_comments" style='width: 100%; height: calc(100% - 130px); border: 1px solid lightgray; word-break:break-all; overflow-y: scroll;'>
                
            </div>
            
            <?php if(!Yii::$app->user->isGuest){ ?>
            
            <textarea style="margin-top: 5px;" id="comment_avatar_input_text" class="form-control" rows="3"></textarea>
            
            <button onclick='SetAvatarComment()' style="float: right; margin-top: 5px;" type="button" class="btn btn-primary">Отправить</button>
            
            <?php }else{ ?>
            
            <div style="word-break:break-all;">
                
                <p>Войдите чтобы оставить комментарий</p>
                
            </div>
            
            <?php } ?>
            
        </div>
        
    </div>
    
</div>