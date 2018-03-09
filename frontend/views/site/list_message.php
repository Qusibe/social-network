<?php

use yii\helpers\Html;
use frontend\assets\List_MessageAsset;
use common\widgets\Navigation_User;
use common\widgets\User_chat;

List_MessageAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<div id="message_list" class="container">
    
    <?php for($i = 0; $i < count($list_data); $i++){ ?>
    
        <div onclick='JumpUserChat(<?= $list_data[$i]['id_user'] ?>)'  type='submit'  data-dismiss='modal' data-toggle='modal' data-target='#modal_user_chat' style="cursor: pointer; margin-bottom: 20px; border: 1px solid lightgray; padding: 10px; width: 100%; height: auto; overflow: hidden; word-break:break-all;" class="container">
            
            <?php
            
             echo Html::beginTag('div', ['style' => 'margin-right: 10px; overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; width: 165px; height: 165px; border: 1px solid lightgray; background-color: white; float: left;']); 

                echo Html::beginTag('div', ['style' => '; width: 100%px; height: 110px; background: url("'.$list_data[$i]['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                echo Html::endTag('div');  

                echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $list_data[$i]['users_info']['name'] . "</p>";
                echo "<p align='center' >" .$list_data[$i]['users_info']['surname'] . "</p>";

            echo Html::endTag('div');   

            ?>
            
            <h4 align="center">Последнее сообщение</h4>
                 
            <p><?= $list_data[$i]['users_message']['message'] ?></p>
            
        </div>
    
    <?php } ?>
    
</div>

<?=  User_chat::widget(); ?>