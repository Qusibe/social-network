<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class User_FriendsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/Social_Network/frontend/web/css/user_friends.css'
    ];
    public $js = [
    ];
    public $depends = [
       
    ];
}
