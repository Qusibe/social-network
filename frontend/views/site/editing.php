<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Navigation_User;
use frontend\assets\EditingAsset;
use yii\helpers\Url;

EditingAsset::register($this);

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<div id="editing_form" class="container">
    
    <p align="center"><IMG onclick="LoadImages()" title="Изменить аватар" SRC="<?= Url::to("@web/site_content/images/load_img.png"); ?>" HEIGHT="auto" WIDTH="10%" style="cursor: pointer;"></p>
    
    <div id="preview_img" class="container" style="width: 100%; height: auto; margin-top: 30px; border: 1px solid #ccc; padding: 20px;">
    
    </div>
    
    <?php $aform = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                            
        <?= $aform->field($edit_form, 'file')->label(false)->fileInput(['accept' => 'image/*', 'id' => 'img_form', 'style' => 'display: none;']); ?>
    
        <?= $aform->field($edit_form, 'name')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Имя', 'style' => 'margin-top: 20px;']); ?>
        <?= $aform->field($edit_form, 'surname')->label(false)->textInput(['placeholder'=>'Фамилия', 'class'=>'form-control input-xs']); ?>                   
        <?= $aform->field($edit_form, 'quote')->label(false)->textInput(['placeholder'=>'Цитата', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'day')->label(false)->dropDownList([
            '' => 'День рождения',
            '1' => '1',
            '2' => '2',
            '3' => '3'
        ], []) ?>
    
        <?= $aform->field($edit_form, 'month')->label(false)->dropDownList([
            '' => 'Месяц рождения',
            'январь' => 'январь',
            'февраль' => 'февраль',
            'август' => 'август'
        ], []) ?>
    
        <?= $aform->field($edit_form, 'year')->label(false)->dropDownList([
            '' => 'Год рождения',
            '2000' => '2000',
            '1999' => '1999',
            '1998' => '1998'
        ], []) ?>
    
        <?= $aform->field($edit_form, 'gender')->label(false)->dropDownList([
            '' => 'Пол',
            'Мужской' => 'Мужской',
            'Женский' => 'Женский'
        ], []) ?>
    
        <?= $aform->field($edit_form, 'hometown')->label(false)->textInput(['placeholder'=>'Родной город', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'city')->label(false)->textInput(['placeholder'=>'Город', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'activity')->label(false)->textInput(['placeholder'=>'Деятельность', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'interests')->label(false)->textInput(['placeholder'=>'Интересы', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'favoritemusic')->label(false)->textInput(['placeholder'=>'Любимая музыка', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'highschool')->label(false)->textInput(['placeholder'=>'Вуз', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'faculty')->label(false)->textInput(['placeholder'=>'Факультет', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'formoftraining')->label(false)->textInput(['placeholder'=>'Форма обучения', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'status')->label(false)->textInput(['placeholder'=>'Статус', 'class'=>'form-control input-xs']); ?>
    
        <?= $aform->field($edit_form, 'schools')->label(false)->textInput(['placeholder'=>'Школа', 'class'=>'form-control input-xs']); ?>

        <?= Html::submitButton('Изменить',['class'=>'btn btn-primary', 'style' => 'float: right; margin-bottom: 20px;']); ?>

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