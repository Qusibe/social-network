<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class Site_searchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/Social-Network/frontend/web/css/site_search.css'
    ];
    public $js = [
    ];
    public $depends = [
       
    ];
}