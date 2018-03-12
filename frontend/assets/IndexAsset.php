<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/Social-Network/frontend/web/css/index.css'
    ];
    public $js = [
    ];
    public $depends = [
       
    ];
}