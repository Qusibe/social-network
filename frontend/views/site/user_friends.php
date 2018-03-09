<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\User_FriendsAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

Html::csrfMetaTags();

User_FriendsAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">
 
        function JumpFriend(id) { 
            window.location = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => '']); ?>" + id;
        } 

</script>


<div id="friends_list" class="container">
    
            <?php 

                foreach ($friends_data['users_friends'] as $model) {

                    echo Html::beginTag('div', ['id' => $model['id_friend'], 'style' => 'overflow: hidden; padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: 120px; height: 175px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpFriend(id)']); 

                        echo Html::beginTag('div', ['style' => 'width: 120px; height: 120px; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

                        echo Html::endTag('div');  

                        echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
                        echo "<p align='center' >" .$model['users_info']['surname'] . "</p>";

                    echo Html::endTag('div');   


                }

            ?>

</div>