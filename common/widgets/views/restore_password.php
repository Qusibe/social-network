<!DOCTYPE html>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

 
<div id='ModalRestorePassword' class='modal fade'>

            <div class='modal-dialog'>

                <div class='modal-content'>

                    <div class='modal-header'>

                        <button class='close' data-dismiss='modal'>x</button>

                        <h4 class='modal-title'>Востановление пароля</h4>

                    </div>

                    <br />

                    <div style="padding: 20px;" class='media-body'>                                             

                        <?php $aform = ActiveForm::begin(); ?>

                            <?= $aform->field($form, 'login')->label(false)->textInput(['class' => 'form-control', 'placeholder'=>'Логин']); ?>
                            <?= $aform->field($form, 'email')->label(false)->textInput(['class' => 'form-control', 'placeholder'=>'Почтовый адрес']); ?>
                            <?= $aform->field($form, 'password')->label(false)->passwordInput(['class' => 'form-control', 'placeholder'=>'Новый пароль']); ?>      

                            <?= Html::submitButton('Востановить', ['class'=>'btn btn-success btn-block']); ?>

                       <?php ActiveForm::end(); ?>

                    </div>    

                    <br />

                    <div class='modal-footer'>

                    </div>

                </div>

            </div>

        </div>

<?php if($form->errors){ ?>

    <script type="text/javascript"> 

           $("#btnClickRestor").click();

    </script>

<?php } ?>

 