<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\IndexAsset;
use yii\helpers\Url;
use common\widgets\Resending_Email;
use common\widgets\ChangeResending_Email;
use common\widgets\Restore_Password;

IndexAsset::register($this);

$this->head() 

?>

<?php
    if(!empty($index_message)){
?>

        <script type="text/javascript"> 

            alert("<?= $index_message ?>");

        </script>

<?php
    }
?>

<?php
    if(Yii::$app->request->get('message')){
?>

        <script type="text/javascript"> 

            alert("<?= Yii::$app->request->get('message') ?>");

        </script>

<?php
    }
?>

<div id="site_info">
    
   <div id="site_text">
        <h3 align="center">Social Network</h3>
        <p align="center">Развлекательная социальная сеть для общения с друзьями, просмотра фильмов и сериалов, прослушивания музыки и многого другого.</p>
    </div>
    
    <div id="site_img">
                
        <p align="center"><img src="<?= Url::to("@web/site_content/images/index_img.jpg"); ?>"  HEIGHT="auto" WIDTH="90%"  /></p>
        
    </div>
    
</div>

<div id="input_form">
    
    <div id="authorization_form">
     
        <?php $form = ActiveForm::begin(['enableAjaxValidation'   => false, 'enableClientValidation' => false]); ?>
                              
            <?= $form->field($authorization_form, 'login')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Логин']); ?>
            <?= $form->field($authorization_form, 'password')->label(false)->passwordInput(['placeholder'=>'Пароль', 'class'=>'form-control input-xs']); ?> 
        
            <?php if($authorization_form->errors){ ?>
                
                    <a href="" class="btn btn-link" style="margin-bottom: 10px;" data-dismiss="modal" data-toggle="modal" data-target="#ModalAuthHelp">Нужна помощь?</a>
        
            <?php } ?>
        
            <?= $form->field($authorization_form, 'rememberMe')->label(false)->checkbox(['label' => 'Запомнить меня']) ?>
           
            <?= Html::submitButton('Войти',['class'=>'btn btn-primary']); ?>

            <?php echo '<a href="" class="btn btn-link"  data-dismiss="modal" data-toggle="modal" data-target="#ModalRestorePassword">Забыли пароль?</a>' ?>

        <?php ActiveForm::end(); ?> 
        
    </div>
    
    <div id="registration_form">
        
        <?php $form = ActiveForm::begin(['enableAjaxValidation'   => false, 'enableClientValidation' => false]); ?>

            <?= $form->field($registration_form, 'name')->label(false)->textInput([ 'class' => 'form-control input-xs', 'placeholder'=>'Ваше Имя']); ?>
            <?= $form->field($registration_form, 'surname')->label(false)->textInput([ 'class' => 'form-control input-xs', 'placeholder'=>'Ваша Фамилия']); ?>
            <?= $form->field($registration_form, 'email')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Почтовый адрес']); ?>
            <?= $form->field($registration_form, 'login')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Логин']); ?>
            <?= $form->field($registration_form, 'password')->label(false)->passwordInput(['class' => 'form-control input-xs', 'placeholder'=>'Пароль']); ?>      

            <?= Html::submitButton('Зарегестрироватся', ['class'=>'btn btn-success btn-block']); ?>

        <?php ActiveForm::end(); ?>

    </div>
    
</div>
        
<?php if(Yii::$app->user->isGuest){ ?>
           
    <?=  Restore_Password::widget(); ?> 

<?php } ?>
        
<div id='ModalAuthHelp' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <button class='close' data-dismiss='modal'>x</button>

                <h4 class='modal-title'>Помощь</h4>

            </div>

            <br />

            <div style="padding: 20px;" class='media-body'>                                             

               <h4 align="center">Ваш акаунт не активирован</h4>

                   <?=  Resending_Email::widget(); ?> 

                   <?=  ChangeResending_Email::widget(); ?>

            </div>    

            <br />

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>