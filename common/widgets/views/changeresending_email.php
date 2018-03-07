<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<button style="margin-bottom: 10px;" type="button" class="btn btn-link btn-block" data-toggle="collapse" data-target="#form_changeresending">
  Изменить Email и отправить письмо
</button>


<div id="form_changeresending" class="collapse">

    <?php $form = ActiveForm::begin(); ?>
        
        <?= $form->field($form_chres, 'login')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Логин']); ?>
        <?= $form->field($form_chres, 'password')->label(false)->passwordInput(['placeholder'=>'Пароль', 'class'=>'form-control input-xs']); ?> 
        <?= $form->field($form_chres, 'email')->label(false)->textInput(['class' => 'form-control input-xs', 'placeholder'=>'Новый Email']); ?>

        <?= Html::submitButton('Отправить',['class'=>'btn btn-info btn-block', 'style' => 'margin-top: 20px;']); ?>

    <?php ActiveForm::end(); ?>

    <?php
        if(!empty($message)){
    ?>

            <script type="text/javascript"> 

                alert("<?= $message ?>");

            </script>

    <?php
        }
    ?>
      
</div>