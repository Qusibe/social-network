<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\Editing_groupsAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

Html::csrfMetaTags();

Editing_groupsAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<div id="editing_form" class="container">
    
    <p align="center"><IMG onclick="LoadImages()" title="Изменить аватар группы" SRC="<?= Url::to("@web/site_content/images/load_img.png"); ?>" HEIGHT="auto" WIDTH="10%" style="cursor: pointer;"></p>
    
    <div id="preview_img" class="container" style="width: 100%; height: auto; margin-top: 30px; border: 1px solid #ccc; padding: 20px;">
    
    </div>
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                            
        <?= $form->field($edit_groups_form, 'file')->label(false)->fileInput(['accept' => 'image/*', 'id' => 'img_form', 'style' => 'display: none;']); ?>
    
        <?= $form->field($edit_groups_form, 'description_groups')->label(false)->textarea(['placeholder'=>'Описание группы', 'rows' => 6]) ?>
    
        <?= $form->field($edit_groups_form, 'id_groups')->label(false)->textInput(['value' => '' . Yii::$app->request->get('id') .'', 'style' => 'display: none;']); ?>
    
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary', 'style' => 'float: right;']) ?>
    
    <?php ActiveForm::end(); ?>
    
</div>

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