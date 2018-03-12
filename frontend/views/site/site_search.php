<?php
use yii\helpers\Html;
use common\widgets\Navigation_User;
use frontend\assets\Site_searchAsset;

Site_searchAsset::register($this);

$this->head();
?>

<div id="nav_page_user" class="container">
   
    <?=  Navigation_User::widget(); ?>
    
</div>

<script language="javascript" type="text/javascript">
 
                function JumpPageUser(id) { 
                    window.location = "<?= Yii::$app->urlManager->createUrl(['/site/user_page' , 'id' => '']); ?>" + id;
                } 
 
</script>

 <script language="javascript" type="text/javascript">
 
                function JumpGroups(id) { 
                    window.location = "<?= Yii::$app->urlManager->createUrl(['/site/groups_page' , 'id' => '']); ?>" + id;
                } 
 
</script>

<div id="site_search_form" class="container">
    
    <?php
    
        foreach ($search['user'] as $model) {
            
            echo Html::beginTag('div', ['id' => $model['id_user'], 'style' => 'cursor: pointer; width: 180px; height: 235px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpPageUser(id)']); 
                      
                    echo Html::beginTag('div', ['style' => 'width: 180px; height: 180px; background: url("'.$model['users_avatar']['avatar'].'") no-repeat center/cover;']); 
                 
                    echo Html::endTag('div');  
                   
                    echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>".$model['name']."</p>";
                    echo "<p align='center' >".$model['surname']."</p>";
        
            echo Html::endTag('div');   
                      
        }
        
        foreach ($search['groups'] as $model) {
            
             echo Html::beginTag('div', ['id' => $model['id'], 'style' => 'padding: 0px; margin-left: 10px; margin-top: 10px; cursor: pointer; width: 180px; height: 235px; border: 1px solid lightgray; background-color: white; float: left;', 'onclick' => 'JumpGroups(id)']); 

                    echo Html::beginTag('div', ['style' => '; width: 180px; height: 180px; background: url("'.$model['way_images'].'") no-repeat center/cover;']); 

                    echo Html::endTag('div');  

                    echo "<p align='center' style='margin-top: 5px; margin-bottom: 0px;'>".$model['name_groups']."</p>";                    

            echo Html::endTag('div');

        }
             
    ?>
    
</div>

