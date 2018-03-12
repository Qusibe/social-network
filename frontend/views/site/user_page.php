<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\User_PageAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;
use common\widgets\User_chat;

Html::csrfMetaTags();

User_PageAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<?=  User_chat::widget(); ?>

<script language="javascript" type="text/javascript">

    function JumpViewImg(id){

        window.location = "<?= Yii::$app->urlManager->createUrl(['/site/view_images', 'id' => Yii::$app->request->get('id') , 'id_images' => '']); ?>" + id;

    }
    
    function JumpFriend(id) { 
        window.location = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => '']); ?>" + id;
    } 
    
    function JumpGroups(id) { 
        window.location = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => '']); ?>" + id;
    } 
    
    function LikeAvatar(id) { 
     
        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/like_user_avatar']); ?>",
            data: {id: id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {
          
                if($.parseJSON(data)){

                    var elem1 = document.getElementById('number_like');

                    elem1.innerText = Number(elem1.innerText) + 1;

                }else{

                    alert("Вы уже ставили лайк");

                }
            
            }                                 
        });
       
    } 
    
    function DeleteWall(id)
    {
        if(confirm('Удалить запись на стене?')){                              

        }else{

            return;

        }   

        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/dell_user_wall']); ?>",
            data: {id_wall: id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {

                if($.parseJSON(data)){

                    alert("запись удаленна.")

                    window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";

                }else{

                    alert("Произошла ошибка!");

                }

            }                                 
        });

    }
    
    function LikeWallUser(id){
                
        var DataWallLike;

        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/like_user_wall']); ?>",
            data: {id: id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {
            DataWallLike = $.parseJSON(data);                       
            }                                 
        });

        if(DataWallLike){

            var elem1 = document.getElementById('number_wall_like' + id);

            elem1.innerText = Number(elem1.innerText) + 1;

        }else{

            alert("Вы уже ставили лайк");

        }

    }       
    
    function AddFriend() { 
                  
            if(confirm('Добавить этого пользователя в друзья?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/add_friends']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Пользователю отправлен запросс на добавление в друзья.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
            
        }
               
        function DellApplication() { 
                  
            if(confirm('Отклонить запросс?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/dell_application']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Запросс на добавления в друзья отклонен.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
                      
        } 
        
        function DellFriends() { 
                  
            if(confirm('Удалить из друзей?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/dell_friends']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("<?= $user_data['user_info']['users_info']['name'] ?> <?= $user_data['user_info']['users_info']['surname'] ?> Удален из друзей.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
                    
        } 
        
        function DellSubscribers() { 
                  
            if(confirm('Отклонить дружбу?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/dell_subscribers']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Дружба отклонена.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
                   
        } 
        
        function AddSubscribers() { 
                  
            if(confirm('Добавить в список друзей?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/add_subscribers']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Добавлен в список друзей.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
                   
        } 
      
</script>

<div id="content_page_user" class="container">
    
    <div id="user_content_left">
        
        <div id="user_avatar">
            
            <div onclick='JumpAvatar(<?= $user_data['user_info']['users_avatar']['id_user'] ?>)' style='cursor: pointer; width: 100%; height: 300px; background: url("<?= $user_data['user_info']['users_avatar']['avatar'] ?>") no-repeat center/cover;'></div>              
            
           <p id="number_like" style='color: #3C578C; float: right; margin:8px 5px 5px 5px;'><?= count($user_data['user_info']['like_avatar']) ?></p>
            
            <img onclick = 'LikeAvatar(<?= $user_data['user_info']['users_avatar']['id_user'] ?>)' style='margin-bottom: 5px; margin-top: 5px; cursor: pointer; float: right;' src="<?=  Url::to("@web/site_content/images/Like.jpg") ?>"  HEIGHT="20" WIDTH="20"  />               
            
            <?php if($user_data['user_status'] === 'this'){ ?>
            
                <button type='submit' class='btn btn-success btn-block' data-dismiss='modal' data-toggle='modal' data-target='#ModalSubscribers' style="margin-top: 10px;">Подписчики: <?= count($user_data['users_subscribers']) ?></button>
            
            <?php } ?>
                
            <?php if($user_data['user_status'] === 'friends'){ ?>
               
                <img onclick='DellFriends()' title="Удалить из друзей?" style='margin-right: 10px; margin-bottom: 5px; margin-top: 5px; cursor: pointer; float: right;' src="<?=  Url::to("@web/site_content/images/Delete.jpg") ?>"  HEIGHT="20" WIDTH="20"  />            
                
                <button onclick='JumpUserChat(<?= Yii::$app->request->get('id') ?>)'  type='submit' class='btn btn-primary btn-block' data-dismiss='modal' data-toggle='modal' data-target='#modal_user_chat' style="margin-top: 10px;">Написать сообщение</button>
                
                <button onclick='JumpVideoChat(<?= Yii::$app->request->get('id') ?>, "<?= $user_data['user_info']['users_info']['name'] ?>", "<?= $user_data['user_info']['users_info']['surname'] ?>")' type='submit' class='btn btn-info btn-block' style="margin-top: 10px;">Позвонить</button>
                          
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
            
            <?php 
                           
                    foreach ($user_data['user_info']['users_friends'] as $model) {

                        echo Html::beginTag('div', ['id' => $model['id_friend'], 'style' => 'overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); height: 165px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpFriend(id)']); 

                            echo Html::beginTag('div', ['style' => '; width: 100%; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                            echo Html::endTag('div');  

                            echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
                            echo "<p align='center' >" . $model['users_info']['surname'] . "</p>";

                        echo Html::endTag('div');   


                    }

            ?>
            
        </div>
        
        <div id="user_groups">
            
            <p align="center" style="margin-top: 10px; margin-bottom: 0px;"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/list_groups', 'id' => Yii::$app->request->get('id')]); ?>">Группы</a></p>
            
            <?php
            
                    foreach ($user_data['user_info']['users_groups'] as $model) {

                        echo Html::beginTag('div', ['id' => $model['id'], 'style' => 'overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); height: 165px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpGroups(id)']); 

                                echo Html::beginTag('div', ['style' => '; width: 110%; height: 110px; background: url("'.$model['way_images'].'") no-repeat center/cover;']); 

                                echo Html::endTag('div');  

                                echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>".$model['name_groups']."</p>";


                        echo Html::endTag('div'); 

                    }           
                
            ?>
            
            <?php
        
                    foreach ($user_data['participants_groups'] as $model) {

                        echo Html::beginTag('div', ['id' => $model['users_groups']['id'], 'style' => 'overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); height: 165px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpGroups(id)']); 

                                echo Html::beginTag('div', ['style' => '; width: 110%; height: 110px; background: url("'.$model['users_groups']['way_images'].'") no-repeat center/cover;']); 

                                echo Html::endTag('div');  

                                echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>".$model['users_groups']['name_groups']."</p>";


                        echo Html::endTag('div'); 

                    }  
                
            ?>
            
        </div>
                
    </div>
  
    <div id="user_content_right">
        
        <div id="user_info">
            
            <h4 style="color:#269abc;"><?= $user_data['user_info']['users_info']['name'] ?> &nbsp <?= $user_data['user_info']['users_info']['surname'] ?><p style="color: #9acfea; float: right;"><?= $user_data['online'] ?></p></h4>                      
           
            <?php if(!empty($user_data['user_info']['users_info']['quote'])){ ?>
            
                <p style="color:#269abc;"><?= $user_data['user_info']['users_info']['quote'] ?></p>                      
            
            <?php } ?>
                       
            <hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />          
            
            <?php if(!empty($user_data['user_info']['users_info']['birthday'])){ ?>
            
                <p style="clear: both;color: #9acfea;">День рождения: <span style="margin-left: 40px; color:#269abc;"><?= $user_data['user_info']['users_info']['birthday'] ?></span></p>
            
            <?php } ?>
            
            <?php if(!empty($user_data['user_info']['users_info']['gender'])){ ?>                       
                
                <p style="color:#9acfea;">Пол: <span style="margin-left: 115px; color:#269abc;"><?= $user_data['user_info']['users_info']['gender'] ?></span> </p>
            
            <?php } ?>
            
            <?php if(!empty($user_data['user_info']['users_info']['hometown'])){ ?>
            
                <p style="color:#9acfea;">Родной город: <span style="margin-left: 53px; color:#269abc;"><?= $user_data['user_info']['users_info']['hometown'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Контактная информация &nbsp&nbsp</p> <hr style=" margin-top: 9px; width: calc(100% - 175px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
                
            <?php if(!empty($user_data['user_info']['users_info']['city'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Город: <span style="margin-left: 105px; color:#269abc;"><?= $user_data['user_info']['users_info']['city'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Личная информация &nbsp&nbsp</p> <hr style=" margin-top: 9px; width:  calc(100% - 150px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
                   
            <?php if(!empty($user_data['user_info']['users_info']['activity'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Деятельность: <span style="margin-left: 50px; color:#269abc;"><?= $user_data['user_info']['users_info']['activity'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['interests'])){ ?>
            
                <p style="color:#9acfea;">Интересы:<span style="margin-left: 80px; color:#269abc;"><?= $user_data['user_info']['users_info']['interests'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['favoritemusic'])){ ?>
            
                <p style="color:#9acfea;">Любимая музыка:<span style="margin-left: 33px; color:#269abc;"><?= $user_data['user_info']['users_info']['favoritemusic'] ?></span> </p>
            
            <?php } ?>
                
             <nobr><p style="color:#269abc; float:left;">Образование &nbsp&nbsp</p> <hr style=" margin-top: 9px; width:  calc(100% - 100px); height:1px;border:none;color:lightgray;background-color:lightgray; float:left;"/></nobr>              
              
            <?php if(!empty($user_data['user_info']['users_info']['highschool'])){ ?>
            
                <p style="clear: both;color:#9acfea;">Вуз:<span style="margin-left: 125px; color:#269abc;"><?= $user_data['user_info']['users_info']['highschool'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['faculty'])){ ?>
            
                <p style="color:#9acfea;">Факультет: <span style="margin-left: 75px; color:#269abc;"><?= $user_data['user_info']['users_info']['faculty'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['formoftraining'])){ ?>
            
                <p style="color:#9acfea;">Форма обучения:<span style="margin-left: 38px; color:#269abc;"><?= $user_data['user_info']['users_info']['formoftraining'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['status'])){ ?>
            
                <p style="color:#9acfea;">Статус:<span style="margin-left: 102px; color:#269abc;"><?= $user_data['user_info']['users_info']['status'] ?></span> </p>
            
            <?php } ?>
                
            <?php if(!empty($user_data['user_info']['users_info']['schools'])){ ?>
            
                <p style="color:#9acfea;">Школа:<span style="margin-left: 104px; color:#269abc;"><?= $user_data['user_info']['users_info']['schools'] ?></span> </p>
            
            <?php } ?>
            
        </div>
       
        <ul id="user_images">
                 
            <p align="center" style=""><a  href="<?= Yii::$app->urlManager->createUrl(['/site/view_images', 'id' => Yii::$app->request->get('id')]); ?>">Фотографии пользователя</a></p>            
            
           <?php 
       
                    foreach ($user_data['user_info']['users_images'] as $model) {

                        echo "<li onclick='JumpViewImg(".$model['id'].")' style='cursor: pointer; display:inline-block; margin-left: 5px;  width: 150px; height: 150px; background: url(". $model['way_images'] . ") no-repeat center/cover;'></li>";

                    }

            ?>
            
        </ul>
             
        <div id="user_wall">
           
            <?php  if($user_data['button_wall']){ ?>
            
                <button type='submit' id="button_user_wall" class='btn btn-default btn-block'  data-dismiss='modal' data-toggle='modal' data-target='#modal_user_wall' >Оставить запись</button>
            
            <?php }  ?>
                
            <?php
  
                    foreach ($user_data['user_info']['users_wall'] as $model) {

                        echo "<div style='margin-top: 20px; width: 100%; height: auto;'>";
                    
                            echo "<div style=' margin-bottom: 10px; width: 100%; height: 50px;'>";

                               echo Html::beginTag('div', ['onclick' => 'JumpFriend('.$model['id_friend'].')', 'style' => 'cursor: pointer; margin-right: 10px; float: left; width: 50px; height: 50px; background: url("'. $model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                               echo Html::endTag('div');  

                               echo "<div style='width: calc(100% - 110px); float: left;'>";
                               
                                    echo "<p align='center' style='overflow-x: hidden;'>". $model['users_info']['name'] . " ". $model['users_info']['surname'] ."</p>";
                               
                               echo "</div>";
                               
                               echo "<div onclick='LikeWallUser(".$model['id'].")' style='float: left; cursor: pointer;  width: 50px; height: 50px;'>";
                               
                                    echo '<p align="center" style="margin-bottom: 0px;"><img src="'. Url::to("@web/site_content/images/Like.jpg") .'"  HEIGHT="20" WIDTH="20"  /></p>';
                                    
                                    echo "<p align='center' id='number_wall_like".$model['id']."' style='color: #3C578C;'>". count($model['users_wall_like']) ."</p>";
                                   
                               echo "</div>";
                               
                            echo "</div>";

                        if(!empty($model['message'])){    
                            
                            echo "<p style='margin: 10px;'>- ". $model['message'] ."</p>"; 
                        
                        }
                            
                        if($model['format'] === "images"){
                       
                            echo "<div style='width: 100%; height: 250px; background: url(". $model['way_file'] . ") no-repeat center/cover;'></div>";                                           
                           
                        }
                        
                        if($model['format'] === "video"){
                           
                            echo '<video src="'. $model['way_file'] .'" controls width="100%" height="250px"></video>';                                 
                        
                        }
                        
                        if($model['format'] === "audio"){
                            
                            echo '<audio src="'. $model['way_file'] .'" controls></audio>';
                            
                        }                                                  
                        
                        echo "</div>";
                        
                        if(Yii::$app->request->get('id') == Yii::$app->user->id || Yii::$app->user->id == $model['id_friend']){
                            
                            echo Html::submitButton('Удалить',['onclick' => 'DeleteWall('.$model['id'].')' ,'class'=>'btn btn-warning btn-xs', 'style' => 'margin: 3px; float: right;']);                                  
                            
                        }
                        
                        echo '<hr style="clear: both;height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                   
                    }
 
                ?>
                
        </div>
        
    </div>
    
</div>

<?php if($user_data['user_status'] === 'this'){ ?>

    <div id='ModalSubscribers' class='modal fade'>

            <div class='modal-dialog'>

                <div class='modal-content'>

                    <div class='modal-header'>

                        <button class='close' data-dismiss='modal'>x</button>

                        <h4 class='modal-title'>Подписчики</h4>

                    </div>

                    <br />

                    <div class='media-body' style="overflow-y: auto;  padding: 20px; ">                                             

                        <?php 

                            foreach ($user_data['users_subscribers'] as $model) {

                                echo Html::beginTag('div', ['id' => $model['id_friend'], 'style' => 'overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: 120px; height: 175px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpFriend(id)']); 

                                    echo Html::beginTag('div', ['style' => 'width: 120px; height: 120px; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                                    echo Html::endTag('div');  

                                    echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
                                    echo "<p align='center' >" .$model['users_info']['surname'] . "</p>";

                                echo Html::endTag('div');   

                            }

                        ?>

                    </div>    

                    <br />

                    <div class='modal-footer'>

                    </div>

                </div>

            </div>

    </div>

<?php } ?>

<div id='modal_user_wall' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Запись на стене</h4>

            </div>

            <br />

            <div class='media-body' style="padding: 20px; ">   

                <?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation'   => false, 'enableClientValidation' => false, 'enctype' => 'multipart/form-data']]) ?>
 
                    <?= $form->field($user_wall_form, 'user_file[]')->label(false)->fileInput(); ?>

                    <?= $form->field($user_wall_form, 'message')->label(false)->textarea(['rows' => 6]) ?>

                    <?= $form->field($user_wall_form, 'id_user')->label(false)->textInput(['value' => '' . Yii::$app->request->get('id') .'', 'style' => 'display: none;']); ?>

                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['id' => 'BtnPhotoForm', 'class' => 'btn btn-primary', 'style' => 'float: right;']) ?>
                    </div>

                <?php ActiveForm::end() ?>
             
            </div>    

            <br />

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>

<script language="javascript" type="text/javascript">
        
       var id_avatar;
       var size_comment = 0;
        
       function JumpAvatar(id)
        {        
            id_avatar = id;
            
            document.querySelector('#user_set_avatar_comments').innerHTML = '';
            
            $("#preview_avatar").show("slow");
            
            $("#user_show_avatar").css('background','url("<?= $user_data['user_info']['users_avatar']['avatar'] ?>") no-repeat');         
            $("#user_show_avatar").css('background-size','100% auto');
            $("#user_show_avatar").css('background-position','center');
            
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_avatar_user']); ?>",
                data: {id: id_avatar, comment: '', size: 0, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                   
                    var comment_data = $.parseJSON(data);
                                       
                    size_comment = comment_data['comments'].length;                  
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#user_set_avatar_comments').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#user_set_avatar_comments').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#user_set_avatar_comments').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                    }

                }                                 
            });
            
            setTimeout(CommentAvatarScroll, 1000);
           
        }
        
        function CommentAvatarScroll()
        {
            document.getElementById("user_set_avatar_comments").scrollTop=document.getElementById("user_set_avatar_comments").scrollHeight;
        }
        
        window.onload = function() {
                      
            var div = document.getElementById("preview_avatar");

            div.onclick = function (e) {

                var e = e || window.event;

                var target = e.target || e.srcElement;

                if (this == target){
                   
                    $("#preview_avatar").hide("slow");

                }

            };

        };

        function SetAvatarComment(){
           
            var text = document.getElementById('comment_avatar_input_text').value;
            
            if(text == ''){
                
                return;
                
            }
            
            document.getElementById('comment_avatar_input_text').value = '';
           
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_avatar_user']); ?>",
                data: {id: id_avatar, comment: text, size: size_comment, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                                    
                    var comment_data = $.parseJSON(data);                                       
                
                    size_comment += comment_data['comments'].length;
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#user_set_avatar_comments').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#user_set_avatar_comments').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#user_set_avatar_comments').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                        if(comment_data['comments'].length > 0){
                    
                            document.getElementById("user_set_avatar_comments").scrollTop=document.getElementById("user_set_avatar_comments").scrollHeight;
                    
                        }
                        
                    }
               
                }                                 
            });
            
        }

     
</script>

<div id="preview_avatar">
    
    <div id="content_avatar">
        
        <div id="user_show_avatar" style="width: 75%; height: 100%; float: left;">
            
         
        </div>
        
       <div id="user_avatar_comments" style="padding: 5px; width: 25%; height: 100%; float: left; background-color: white;">
                        
            <div id="user_set_avatar_comments" style='width: 100%; height: calc(100% - 130px); border: 1px solid lightgray; word-break:break-all; overflow-y: scroll;'>
                
            </div>
            
            <?php if($user_data['user_status'] === 'this' || $user_data['user_status'] === 'friends'){ ?>
            
            <textarea style="margin-top: 5px;" id="comment_avatar_input_text" class="form-control" rows="3"></textarea>
            
            <button onclick='SetAvatarComment()' style="float: right; margin-top: 5px;" type="button" class="btn btn-primary">Отправить</button>
            
            <?php }else{ ?>
            
            <div style="word-break:break-all;">
                
                <p>Вы не можете оставлять комментарии</p>
                
            </div>
            
            <?php } ?>
            
        </div>
        
    </div>
    
</div>