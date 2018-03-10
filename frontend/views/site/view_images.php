<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\View_imagesAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;
Html::csrfMetaTags();

View_imagesAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<div id="images" class="container">
    
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == Yii::$app->request->get('id')){ ?>
    
    <p align="center"><IMG onclick="LoadPhoto()" title="Загрузить изображения" SRC="<?= Url::to("@web/site_content/images/load_img.png"); ?>" HEIGHT="auto" WIDTH="10%" style="margin-top: 50px; cursor: pointer; border: 1px solid #ccc;"></p>

        <script language="javascript" type="text/javascript">


            function LoadPhoto()
            {                          

                $("#photo_img_form").trigger('click');

            }

        </script>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($add_images, 'imageFiles[]')->label(false)->fileInput(['multiple' => true, 'accept' => 'image/*', 'id' => 'photo_img_form', 'style' => 'display: none;']) ?>

            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['id' => 'btn_photo_form', 'class' => 'btn btn-primary', 'style' => 'float: right; margin-right: 20%;  margin-top: 30px;']) ?>
            </div>

        <?php ActiveForm::end() ?>

        <div id="arr_img" class="container" style="float: left; width: 80%; margin-left: 10%; height: auto; margin-top: 30px; border: 1px solid #ccc;">

        </div>

    <?php } ?>
        
    <div style="width: 100%; height: auto;">

        <?php
       
            for($i = 0; $i < count($data_img['images']); $i++){
                
               echo "<div style='margin: 5px; float: left; width: 150px; height: 170px;'>";
                
               echo "<div onclick='JumpPhoto(id)' id='".$i."' style='cursor: pointer; width: 150px; height: 150px; background: url(". $data_img['images'][$i]['way_images'] . ") no-repeat center/cover;'></div>";                                       
               
               if($data_img['images'][$i]['id_user'] == Yii::$app->user->id){
                   
                   echo Html::submitButton('Удалить',['onclick' => 'DeleteImages('.$i.')' ,'class'=>'btn btn-warning btn-xs btn-block', 'style' => 'margin-top: 3px;']);
                   
               }
               
               echo "</div>";
               
            }  
            
            echo '<script language="javascript" type="text/javascript">';
    
            echo 'var arrImg = Array();';

            for($i = 0; $i < count($data_img['images']); $i++){

                    echo 'arrImg['.$i.'] = new Object();';
                    
                    echo 'arrImg['.$i.'] = { id: '. $data_img['images'][$i]['id'] .' , way: "'. $data_img['images'][$i]['way_images'] .'" };';

            }

            echo '</script>';
        
        ?>
        
    </div>
        
</div>

<script language="javascript" type="text/javascript">

        var id_images = 0;
        var size_comment = 0;

        function JumpPhoto(id) {
            
            id_images = id;
            
            size_comment = 0;
            
            window.history.pushState(null, null, "<?= Yii::$app->urlManager->createUrl(['/site/view_images', 'id' => Yii::$app->request->get('id'), 'id_images' => '']); ?> " + id);
            
            document.querySelector('#user_set_comments').innerHTML = '';
            
            $("#preview_images").show("slow"); 
            
            document.querySelector('#user_images').innerHTML = '<div id="left_img_click" onClick="LeftClick()"> </div>';
        
            document.querySelector('#user_images').innerHTML += '<div id="right_img_click" onClick="RightClick()"></div>';
            
            $("#user_images").css('background','url(' + arrImg[id].way +') no-repeat');         
            $("#user_images").css('background-size','100% auto');
            $("#user_images").css('background-position','center');
            
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_images_user']); ?>",
                data: {id: arrImg[id_images].id, comment: '', size: 0, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    var comment_data = $.parseJSON(data);
                    
                    var elem1 = document.getElementById('number_like');
                
                    elem1.innerText = comment_data['like'];
                
                    size_comment = comment_data['comments'].length;                  
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#user_set_comments').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#user_set_comments').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#user_set_comments').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                    }

                }                                 
            });
            
            setTimeout(CommentScroll, 1000);
            
        }
        
        function CommentScroll()
        {
            document.getElementById("user_set_comments").scrollTop=document.getElementById("user_set_comments").scrollHeight;
        }

        window.onload = function() {
            
            <?php  if(Yii::$app->request->get('id_images')){ ?>
                    
                    for(var i = 0; i < arrImg.length; i++)
                    
                        if(arrImg[i].id == <?= Yii::$app->request->get('id_images') ?>){

                            JumpPhoto(i);

                            break;
                        }    
                    
            <?php  } ?>        
            
            $('#photo_img_form').change(function() {

              var input = $(this)[0];

              for(var i = 0; i < input.files.length; i++){

                    if ( input.files && input.files[i] ) {

                      if ( input.files[0].type.match('image.*') ) {

                        var reader = new FileReader();

                        reader.onload = function(e) { 

                           document.querySelector('#arr_img').innerHTML +='<IMG  SRC="' + e.target.result +'"   HEIGHT="auto" WIDTH="150" style="margin: 5px;" >'; 

                        };

                        reader.readAsDataURL(input.files[i]);

                      }

                    }

              }

            });
        
            var div = document.getElementById("preview_images");

            div.onclick = function (e) {

                var e = e || window.event;

                var target = e.target || e.srcElement;

                if (this == target){

                    id_images = 0;

                    $("#preview_images").hide("slow");

                }

            };

        };

        function LeftClick()
        { 
            if(id_images <= 0){
                
                return;
                
            }
            
            id_images--;
            
            JumpPhoto(id_images);
        }
        
        function RightClick()
        {
            if(id_images >= arrImg.length - 1){
                
                return;
                
            }
            
            id_images++;
            
            JumpPhoto(id_images);
        }
        
        function SetImgComment(){
           
            var text = document.getElementById('comment_input_text').value;
            
            if(text == ''){
                
                return;
                
            }
            
            document.getElementById('comment_input_text').value = '';
           
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/comment_images_user']); ?>",
                data: {id: arrImg[id_images].id, comment: text, size: size_comment, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    var comment_data = $.parseJSON(data);
                    
                    var elem1 = document.getElementById('number_like');
                
                    elem1.innerText = comment_data['like'];
                
                    size_comment += comment_data['comments'].length;
                
                    for(var i = comment_data['comments'].length - 1; i >= 0; --i){
                                               
                        document.querySelector('#user_set_comments').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + comment_data['comments'][i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                        +"<h5 style='' class='modal-title'>"+comment_data['comments'][i].users_info.name + " " + comment_data['comments'][i].users_info.surname+"</h5></div><br>";
                
                        document.querySelector('#user_set_comments').innerHTML += '<p>' + comment_data['comments'][i].comment + ' </p>';
                    
                        document.querySelector('#user_set_comments').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                        
                        if(comment_data['comments'].length > 0){
                    
                            document.getElementById("user_set_comments").scrollTop=document.getElementById("user_set_comments").scrollHeight;
                    
                        }
                        
                    }
               
                }                                 
            });
            
        }
        
        function DeleteImages(id)
        {
            
            if(confirm('Удалить это изображение?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/del_user_images']); ?>",
                data: {id: arrImg[id].id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                                               
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/view_images' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
            
        }
        
        function LikeImgUser()
        {        
            var DataUserLike;
            
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/like_user_images']); ?>",
                data: {id: arrImg[id_images].id, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                DataUserLike = $.parseJSON(data);                       
                }                                 
            });
            
            if(DataUserLike){
                
                var elem1 = document.getElementById('number_like');
                
                elem1.innerText = Number(elem1.innerText) + 1;
                
            }else{
               
                    alert("Вы уже ставили лайк");
                
                }
           
        
        }             

</script>

<div id="preview_images">
    
    <div id="content_images">
        
        <div id="user_images" style="width: 75%; height: 100%; float: left;">
            
         
        </div>
        
        <div id="user_comments" style="padding: 5px; width: 25%; height: 100%; float: left; background-color: white;">
            
            <div style='cursor: pointer; float: left; width: 50px; height: 50px; background: url( <?= $data_img['user']->users_avatar->avatar ?> )no-repeat center/cover;'>
                
            </div>
            
            <div style='width: calc(100% - 100px); float: left;'>
                
                <p align="center" style='overflow-x: hidden;'><?= $data_img['user']->name ?></p>
                
                <p align="center" style='overflow-x: hidden;'><?= $data_img['user']->surname ?></p>
                
            </div>
                                   
            <div onclick="LikeImgUser()" style='float: left; cursor: pointer;  width: 50px; height: 50px;'>
                                            
                <img src="<?=  Url::to("@web/site_content/images/Like.jpg") ?>"  HEIGHT="20" WIDTH="20"  />
                
                <p id="number_like" style='color: #3C578C;'>0</p>
                           
            </div>
            
            <div id="user_set_comments" style='margin-top: 55px; width: 100%; height: calc(100% - 180px); border: 1px solid lightgray; word-break:break-all; overflow-y: scroll;'>
                
            </div>
            
            <?php if(!Yii::$app->user->isGuest){ ?>
            
            <textarea style="margin-top: 5px;" id="comment_input_text" class="form-control" rows="3"></textarea>
            
            <button onclick='SetImgComment()' style="float: right; margin-top: 5px;" type="button" class="btn btn-primary">Отправить</button>
            
            <?php }else{ ?>
            
            <div style="word-break:break-all;">
                
                <p>Войдите чтобы оставить комментарий</p>
                
            </div>
            
            <?php } ?>
            
        </div>
        
    </div>
    
</div>