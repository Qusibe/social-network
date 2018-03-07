<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\widgets\Resending_Email;
use common\widgets\ChangeResending_Email;
use common\widgets\Restore_Password;

?>

<?php if(!Yii::$app->user->isGuest){ ?>

<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/editing']); ?>">Редактирование</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/user_friends', 'id' => Yii::$app->user->id]); ?>">Друзья</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/list_message']); ?>">Сообщения: <?= $size_message ?></a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/view_images', 'id' => Yii::$app->user->id]); ?>">Фотографии</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site']); ?>">Видеозаписи</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site']); ?>">Аудиозаписи</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/list_groups', 'id' => Yii::$app->user->id]); ?>">Группы</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site']); ?>">Звонок</a></p>
<p align="center"><a  href="<?= Yii::$app->urlManager->createUrl(['/site/out_user']); ?>">Выход</a></p>

<hr style  ="height:1px;border:none;color:lightgray;background-color:lightgray;" />

<?php }else{ ?>

     <?php $form = ActiveForm::begin(['enableAjaxValidation'   => false, 'enableClientValidation' => false]); ?>
                              
            <?= $form->field($auth_form, 'login')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Логин']); ?>
            <?= $form->field($auth_form, 'password')->label(false)->passwordInput(['placeholder'=>'Пароль', 'class'=>'form-control input-xs']); ?> 
        
            <?php if($auth_form->errors){ ?>
                
                <p align="center"><a href="" class="btn btn-link" style="margin-bottom: 10px;" data-dismiss="modal" data-toggle="modal" data-target="#ModalAuthHelp">Нужна помощь?</a></p>
        
            <?php } ?>
        
            <p align="center"><?= $form->field($auth_form, 'rememberMe')->label(false)->checkbox(['label' => 'Запомнить меня']) ?></p>
           
            <?= Html::submitButton('Войти',['class'=>'btn btn-primary btn-block']); ?>
            
        <?php ActiveForm::end(); ?> 
                    
        <button id="btn_reg" type='submit' class='btn btn-success btn-block' data-dismiss='modal' data-toggle='modal' data-target='#ModalRegistration' style="margin-top: 10px;">Регестрация</button>        
                        
        <p align="center"><a style="margin-top: 10px;" href="" class="btn btn-link"  data-dismiss="modal" data-toggle="modal" data-target="#ModalRestorePassword">Забыли пароль?</a></p>
        
        <?=  Restore_Password::widget(); ?> 

<?php } ?>
        
<div id='ModalRegistration' class='modal fade'>

        <div class='modal-dialog'>

            <div class='modal-content'>

                <div class='modal-header'>

                    <button class='close' data-dismiss='modal'>x</button>

                    <h4 class='modal-title'>Регистрация</h4>

                </div>

                <br />

                <div style="padding: 20px;" class='media-body'> 

                    <?php $form = ActiveForm::begin(['enableAjaxValidation'   => false, 'enableClientValidation' => false]); ?>

                        <?= $form->field($reg_form, 'name')->label(false)->textInput([ 'class' => 'form-control input-xs', 'placeholder'=>'Ваше Имя']); ?>
                        <?= $form->field($reg_form, 'surname')->label(false)->textInput([ 'class' => 'form-control input-xs', 'placeholder'=>'Ваша Фамилия']); ?>
                        <?= $form->field($reg_form, 'email')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Почтовый адрес']); ?>
                        <?= $form->field($reg_form, 'login')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Логин']); ?>
                        <?= $form->field($reg_form, 'password')->label(false)->passwordInput(['class' => 'form-control input-xs', 'placeholder'=>'Пароль']); ?>      

                        <?= Html::submitButton('Зарегестрироватся', ['class'=>'btn btn-success btn-block']); ?>

                    <?php ActiveForm::end(); ?>

                </div>    

                <br />

                <div class='modal-footer'>

                </div>

            </div>

        </div>

    </div>
    
    <?php if($reg_form->errors){ ?>
    
        <script type="text/javascript"> 
              
            window.onload = function() {
              
               $("#btn_reg").click();
               
            }
              
        </script>
    
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