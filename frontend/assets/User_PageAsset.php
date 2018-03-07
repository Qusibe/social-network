<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class User_PageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/Social_Network/frontend/web/css/user_page.css'
    ];
    public $js = [
    ];
    public $depends = [
       
    ];
}
