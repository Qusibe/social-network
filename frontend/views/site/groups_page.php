<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\Groups_PageAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

Html::csrfMetaTags();

Groups_PageAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">
    
    function RequestEntryGroups()
    {
        
        if(confirm('Вступить в эту группу?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/request_entry_groups']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Отправлен запросс на вступление в группу.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });       
    }
    
    function UnsubscriptionGroups()
    {
        if(confirm('Отозвать запросс на вступление в эту группу?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/unsubscription_groups']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Запросс на вступление в группу отозван.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });        
    }
    
    function LeaveGroups()
    {
        if(confirm('Покинуть эту группу?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/leave_groups']); ?>",
                data: {id: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Вы покинули эту группу.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });        
    }
    
    function addParticipants(id)
    {
        if(confirm('Добавить этого пользователя?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/add_participants']); ?>",
                data: {id_groups: <?= Yii::$app->request->get('id'); ?>, id_user: id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                        
                        alert("Пользователь добавлен.");
                        
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });               
    }
    
    function LikeWallGroups(id){
                
                var DataWallLike;

                $.ajax({
                    async: false,
                    type: "POST",
                    cache: false,
                    url: "<?= Yii::$app->urlManager->createUrl(['/site/like_groups_wall']); ?>",
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
    
    var id_wall;
    var size_comment = 0;
    
    function JumpGroupsComment(id)
    {
        id_wall = id;
        size_comment = 0;
        
        document.querySelector('#set_message').innerHTML = '';
        
        $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_wall_groups']); ?>",
                data: {id: id_wall, id_groups: <?= Yii::$app->request->get('id'); ?>, comment: '', size: 0, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                   
                    var comment_data = $.parseJSON(data);
                                       
                    size_comment = comment_data['comments'].length;                  
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#set_message').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#set_message').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#set_message').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                    }

                }                                 
            });
            
            setTimeout(CommentWallScroll, 1000);
           
        }
        
        function CommentWallScroll()
        {
            document.getElementById("set_message").scrollTop=document.getElementById("set_message").scrollHeight;
        }
        
           
                
    function SetGroupsComments()
    {
        var text = document.getElementById('comment_groups_input_text').value;
            
            if(text == ''){
                
                return;
                
            }
            
            document.getElementById('comment_groups_input_text').value = '';
           
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_wall_groups']); ?>",
                data: {id: id_wall, id_groups: <?= Yii::$app->request->get('id'); ?>, comment: text, size: size_comment, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                              
                    var comment_data = $.parseJSON(data);                                       
                
                    size_comment += comment_data['comments'].length;
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#set_message').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#set_message').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#set_message').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                        if(comment_data['comments'].length > 0){
                    
                            document.getElementById("set_message").scrollTop=document.getElementById("set_message").scrollHeight;
                    
                        }
                        
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
            url: "<?= Yii::$app->urlManager->createUrl(['/site/dell_groups_wall']); ?>",
            data: {id_wall: id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {

                if($.parseJSON(data)){

                    alert("запись удаленна.")

                    window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => Yii::$app->request->get('id')]); ?>";

                }else{

                    alert("Произошла ошибка!");

                }

            }                                 
        });

    }
               
</script>

<div id="groups_content" class="container">
    
    <div id="groups_content_left">
        
        <div id="groups_info">
            
            <h4 align="center"><?= $data_groups['user_groups']->name_groups ?></h4>
            <p align="center"><?= $data_groups['user_groups']->description ?></p>
            
        </div>
        
        <div id="groups_wall">
            
            <?php  if($data_groups['user_status'] === 'this'){ ?>
            
                <button type='submit' id="button_user_wall" class='btn btn-default btn-block'  data-dismiss='modal' data-toggle='modal' data-target='#modal_groups_wall' >Оставить запись</button>
            
            <?php } ?>
                
                <?php
                
                    foreach ($data_groups['groups_wall'] as $model) {

                        echo "<div style='margin-top: 20px; width: 100%; height: auto;'>";
                    
                            echo "<div style=' margin-bottom: 10px; width: 100%; height: 50px;'>";

                               echo Html::beginTag('div', ['onclick' => 'JumpUser('.$model['id_user'].')', 'style' => 'cursor: pointer; margin-right: 10px; float: left; width: 50px; height: 50px; background: url("'. $model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                               echo Html::endTag('div');  

                               echo "<div style='width: calc(100% - 110px); float: left;'>";
                               
                                    echo "<p align='center' style='overflow-x: hidden;'>". $model['users_info']['name'] . " ". $model['users_info']['surname'] ."</p>";
                               
                               echo "</div>";
                               
                               echo "<div onclick='LikeWallGroups(".$model['id'].")' style='float: left; cursor: pointer;  width: 50px; height: 50px;'>";
                               
                                    echo '<p align="center" style="margin-bottom: 0px;"><img src="'. Url::to("@web/site_content/images/Like.jpg") .'"  HEIGHT="20" WIDTH="20"  /></p>';
                                    
                                    echo "<p align='center' id='number_wall_like".$model['id']."' style='color: #3C578C;'>". count($model['groups_wall_like']) ."</p>";
                                   
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
                        
                        echo "<button id='".$model['id']."' onclick='JumpGroupsComment(id)' type='submit' class='btn btn-info btn-block' data-dismiss='modal' data-toggle='modal' data-target='#ModalGroupsComments' style='margin-top: 10px';>Показать коментарии</button>";
                        
                        if($data_groups['user_status'] === 'this'){
                            
                            echo Html::submitButton('Удалить',['onclick' => 'DeleteWall('.$model['id'].')' ,'class'=>'btn btn-warning btn-xs', 'style' => 'margin: 3px; float: right;']);                                  
                            
                        }
                        
                        echo '<hr style="clear: both;height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                   
                    }
                
                ?>
            
        </div>
        
    </div>
    
    <div id="groups_content_right">
       
        <div id="groups_images">
            
            <div style='width: 100%; height: 300px; background: url("<?= $data_groups['user_groups']->way_images ?>") no-repeat center/cover;'></div>                
            
            <?php if($data_groups['user_status'] === 'user'){ ?>
            
                <button type='submit' onclick='RequestEntryGroups()' class='btn btn-success btn-block' style="margin-top: 10px;">Вступить в группу</button>
            
            <?php } ?>
                
            <?php if($data_groups['user_status'] === 'subscribers'){ ?>
            
                <button type='submit' onclick='UnsubscriptionGroups()' class='btn btn-primary btn-block' style="margin-top: 10px;">Отписаться</button>
            
            <?php } ?>
            
            <?php if($data_groups['user_status'] === 'participants'){ ?>
            
                <button type='submit' onclick='LeaveGroups()' class='btn btn-primary btn-block' style="margin-top: 10px;">Покинуть группу</button>
            
            <?php } ?>
            
            <?php if($data_groups['user_status'] === 'this'){ ?>
            
                <button type='submit' onclick='EditingGroups()' class='btn btn-primary btn-block' style="margin-top: 10px;">Редактирование</button>

                <button type='submit' class='btn btn-success btn-block' data-dismiss='modal' data-toggle='modal' data-target='#ModalSubscribers' style="margin-top: 10px;">Подписчики: <?= count($data_groups['subscribers']) ?></button> 

            <?php } ?>
            
        </div>
        
         
        <script language="javascript" type="text/javascript">
 
                function EditingGroups() { 
                    window.location = "<?= Yii::$app->urlManager->createUrl(['/site/editing_groups' , 'id' => Yii::$app->request->get('id')]); ?>";
                } 
 
                function JumpUser(id) { 
                    window.location = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => '']); ?>" + id;
                } 
 
        </script>
        
        <div id="groups_party">
            
            <p align="center" style="margin-top: 10px; margin-bottom: 0px;"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/list_participants_groups', 'id' => Yii::$app->request->get('id')]); ?>">Учасники группы</a></p>           
            
            <?php 
            
                foreach ($data_groups['participants'] as $model) {
                    
                    echo Html::beginTag('div', ['onclick' => 'JumpUser('.$model['id_user'].')', 'style' => 'padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); min-height: 165px; border: 1px solid lightgray; background-color: white; float: left;']); 
                      
                        echo Html::beginTag('div', ['style' => '; width: 100%; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                        echo Html::endTag('div');  
                     
                        echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
                        echo "<p align='center' >" .$model['users_info']['surname'] . "</p>";

                    echo Html::endTag('div');   
                                        
                }
            
            ?>
            
        </div>       
        
        <div id="groups_creator">
            
            <p align="center" style="margin-top: 10px; margin-bottom: 0px;">Создатель группы</p>
                       
            <?php
            
            echo Html::beginTag('div', ['onclick' => 'JumpUser('.$data_groups['user_groups']->id_user.')', 'style' => 'padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); min-height: 165px; border: 1px solid lightgray; background-color: white; float: left;']); 

                echo Html::beginTag('div', ['style' => '; width: 100%; height: 110px; background: url("'.$data_groups['user_groups']->users_avatar->avatar.'") no-repeat center/cover;']); 

                echo Html::endTag('div');  

                echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $data_groups['user_groups']->users_info->name . "</p>";
                echo "<p align='center' >" .$data_groups['user_groups']->users_info->surname . "</p>";
             
            echo Html::endTag('div');   
            
            ?>
            
        </div>
        
    </div>
    
</div>

<?php if($data_groups['user_status'] === 'this'){ ?>

<div id='ModalSubscribers' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Подписчики</h4>

            </div>

            <div class='media-body' style="padding: 20px; ">

            <?php 
            
                foreach ($data_groups['subscribers'] as $model) {
                    
                    echo Html::beginTag('div', ['style' => 'padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(50% - 15px); min-height: 165px; border: 1px solid lightgray; background-color: white; float: left;']); 
                      
                        echo Html::beginTag('div', ['style' => '; width: 100%; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                        echo Html::endTag('div');  
                     
                        echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
                        echo "<p align='center' >" .$model['users_info']['surname'] . "</p>";

                        echo Html::submitButton('Страница', ['class' => 'btn btn-primary btn-xs btn-block', 'onclick' => "window.open('" . Yii::$app->urlManager->createUrl(['/site/user_page', 'id' => $model['id_user']]). "', '_blank')"]);
                        echo Html::submitButton('Добавить', [ 'class' => 'btn btn-success btn-xs btn-block', 'onclick' => "addParticipants(".$model['id_user'].")"]);
                        
                    echo Html::endTag('div');   
                    
                    
                }
            
            ?>

            </div>

            <div class='media-body' style="padding: 20px; ">   

            </div>    

            <br />

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>

<div id='modal_groups_wall' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Запись на стене</h4>

            </div>

            <br />

            <div class='media-body' style="padding: 20px; ">   
                
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
 
                    <?= $form->field($groups_wall_form, 'groups_file[]')->label(false)->fileInput(); ?>

                    <?= $form->field($groups_wall_form, 'message')->label(false)->textarea(['rows' => 6]) ?>

                    <?= $form->field($groups_wall_form, 'id_groups')->label(false)->textInput(['value' => '' . Yii::$app->request->get('id') .'', 'style' => 'display: none;']); ?>

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

<?php } ?>

<div id='ModalGroupsComments' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Коментарии</h4>

            </div>

            <div class='media-body' style="padding: 20px; word-break:break-all">

                <div id='set_message' style="width: 100%; height: calc(100vh - 400px); word-break:break-all; overflow-y: scroll; ">

                </div>
                
                <?php if($data_groups['user_status'] === 'participants' || $data_groups['user_status'] === 'this'){ ?>
                
                <textarea id="comment_groups_input_text" class="form-control" rows="6"></textarea>
                                
                <button onclick='SetGroupsComments()' style="float: right; margin-top: 10px;" type="button" class="btn btn-primary">Отправить</button>

                <?php }else{ ?>
                 
                    <p align="center">Вы не можете оставлять комментарии.</p>
                
                <?php } ?>
                
            </div>

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>