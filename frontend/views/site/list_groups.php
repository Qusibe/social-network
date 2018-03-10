<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\List_GroupsAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

List_GroupsAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">

        function JumpGroups(id) { 
            window.location = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => '']); ?>" + id;
        } 

</script>

<div id="groups_list" class="container">
    
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == Yii::$app->request->get('id')){ ?>
    
        <p align="center"><button type='submit' class='btn btn-success btn-lg' data-dismiss='modal' data-toggle='modal' data-target='#ModalСreatureGroups' style="">Создать группу</button></p>

    <?php } ?>
    
    <hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />

    <div id="my_groups">
    
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == Yii::$app->request->get('id')){ ?>
        
        <h4 align="center">Мои группы</h4>
    
    <?php }else{ ?>
    
        <h4 align="center">Группы пользователя</h4>
    
    <?php } ?>
    
        <?php
            
            foreach ($list_groups['user_groups'] as $model) {

                echo Html::beginTag('div', ['id' => $model->id, 'style' => 'margin-bottom: 10px; overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(30% - 15px); height: 165px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpGroups(id)']); 

                        echo Html::beginTag('div', ['style' => '; width: 110%; height: 110px; background: url("'.$model->way_images.'") no-repeat center/cover;']); 

                        echo Html::endTag('div');  

                        echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>$model->name_groups</p>";


                echo Html::endTag('div'); 

            }  

        ?>
    
    </div>

    <hr style="width: 100%; height:1px;border:none;color:lightgray;background-color:lightgray;" />

    <h4 align="center">Участник в группах</h4>
    
     <?php
            
        foreach ($list_groups['participants_groups'] as $model) {

            echo Html::beginTag('div', ['id' => $model['users_groups']['id'], 'style' => 'margin-bottom: 10px; overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: calc(30% - 15px); height: 165px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpGroups(id)']); 

                    echo Html::beginTag('div', ['style' => '; width: 110%; height: 110px; background: url("'.$model['users_groups']['way_images'].'") no-repeat center/cover;']); 

                    echo Html::endTag('div');  

                    echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>".$model['users_groups']['name_groups']."</p>";


            echo Html::endTag('div'); 

        }  

    ?>
    
</div>

<?php if(!Yii::$app->user->isGuest && Yii::$app->user->id == Yii::$app->request->get('id')){ ?>

<div id='ModalСreatureGroups' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Создание группы</h4>

            </div>

            <br />

            <div class='media-body' style="padding: 20px; ">   

                <p align="center"><IMG onclick="LoadImages()" title="Аватака группы" SRC="<?= Url::to("@web/site_content/images/load_img.png"); ?>" HEIGHT="auto" WIDTH="70px" style="cursor: pointer;"></p>    
                
                <div id="preview_img" class="container" style="width: 100%; height: auto; margin-bottom: 10px; margin-top: 10px; border: 1px solid #ccc; padding: 5px;">
    
                </div>
                
               <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                    <?= $form->field($create_groups, 'name_groups')->label(false)->textInput(['placeholder'=>'Название группы']); ?>                            

                    <?= $form->field($create_groups, 'images_groups')->label(false)->fileInput(['id' => 'img_form','style' => 'display: none;']); ?>

                    <?= $form->field($create_groups, 'description_groups')->label(false)->textarea(['placeholder'=>'Описание группы', 'rows' => 6, 'style' => '']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary', 'style' => 'float: right;']) ?>
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

<script language="javascript" type="text/javascript">
    
   
    function LoadImages()
    {                          
                       
        $("#img_form").trigger('click');
      
    }
    
    window.onload = function() {
    
        $("#img_form").change(function() {

          var input = $(this)[0];

          for(var i = 0; i < input.files.length; i++){

                if ( input.files && input.files[i] ) {

                  if ( input.files[0].type.match('image.*') ) {

                    var reader = new FileReader();

                    reader.onload = function(e) { 

                       document.querySelector('#preview_img').innerHTML ='<p align="center"><IMG  SRC="' + e.target.result +'"   HEIGHT="auto" WIDTH="30%"></p>'; 

                    };

                    reader.readAsDataURL(input.files[i]);

                  }

                }

          }

        });
    
    };
</script>