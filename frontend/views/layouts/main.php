<?php

use yii\helpers\Html;
use frontend\assets\MainAsset;
use common\widgets\Video_Chat;

MainAsset::register($this);

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
    
    <head>
       <meta charset="<?= Yii::$app->charset ?>">
       
       <meta name="viewport" content="width=device-width, initial-scale=1">           

       <title><?= Html::encode($this->title) ?></title>
       
       <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>
        
        <header   class="navbar navbar-default" id="asd">

           <div class="navbar-header">

               <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">  

                       <span class="icon-bar"></span>

                       <span class="icon-bar"></span>

                       <span class="icon-bar"></span>

               </button>      
               
               <a class="navbar-brand" href="<?= Yii::$app->urlManager->createUrl(['/site/index']); ?>">Social Network</a>

           </div>

           <div id="navbarCollapse" class="collapse navbar-collapse">

                    <form class="navbar-form navbar-right">

                   </form>

           </div>

       </header>
                
       <div id="content" class="container">
           
              <?= $content ?>

       </div>
        
       <footer>
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/index']); ?>">Social Network</a>&nbsp &copy &nbsp<?php echo date('Y'); ?>
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/index']); ?>" style=" padding-left: 50px;">Обратная связь</a>
       </footer>

    <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>

<?php if(!Yii::$app->user->isGuest){ ?>

    <?=  Video_Chat::widget(); ?>

<?php } ?>