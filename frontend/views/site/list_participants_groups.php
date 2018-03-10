<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\assets\List_Participants_GroupsAsset;
use common\widgets\Navigation_User;
use yii\helpers\Url;

Html::csrfMetaTags();

List_Participants_GroupsAsset::register($this);

$this->head(); 

?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">
 
        function JumpUser(id) { 
            window.location = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => '']); ?>" + id;
        } 
        
        function DeleteUser(id){
            
            if(confirm('Удалить этого пользователя из группы?')){                              
               
            }else{
                
                return;
                
            }   
                  
            $.ajax({
                async: false,
                type: "POST",
                cache: false,
                url: "<?= Yii::$app->urlManager->createUrl(['/site/del_user_groups']); ?>",
                data: {id_user: id, id_groups: <?= Yii::$app->request->get('id'); ?>, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
                success: function(data) {
                    
                    if($.parseJSON(data)){
                                
                        alert("Пользователь удален из группы.")
                                
                        window.location.href = "<?= Yii::$app->urlManager->createUrl(['/site/list_participants_groups' , 'id' => Yii::$app->request->get('id')]); ?>";
                        
                    }else{
                        
                        alert("Произошла ошибка!");
                        
                    }
                    
                }                                 
            });
            
        }

</script>

<div id="list_participants" class="container">

<?php 

    foreach ($list_participants['participants'] as $model) {

        echo Html::beginTag('div', ['style' => 'padding: 0px; margin-left: 10px; margin-top: 10px; width: 120px; height: 175px; border: 1px solid lightgray; background-color: white; float: left;']); 

            echo Html::beginTag('div', ['onclick' => 'JumpUser('.$model['id_user'].')', 'style' => ' cursor: pointer; width: 100%; height: 110px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 

            echo Html::endTag('div');  

            echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>" . $model['users_info']['name'] . "</p>";
            echo "<p align='center' >" .$model['users_info']['surname'] . "</p>";

            if($list_participants['user_status'] == 'this'){
                
                echo Html::submitButton('Удалить',['onclick' => 'DeleteUser('.$model['id_user'].')' ,'class'=>'btn btn-warning btn-xs btn-block', 'style' => 'margin-top: 3px;']);                  
                
            }
            
        echo Html::endTag('div');   

    }

?>

</div>