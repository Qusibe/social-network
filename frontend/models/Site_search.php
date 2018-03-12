<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_info;
use common\models\Users_groups;

class Site_search extends Model
{
    public $str_search;   
    
    public function rules()
    {
        return [            
            ['str_search', 'safe'],              
        ];
    }   
    
    public function Search()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
       
        $sqlArray = explode(" ", $this->str_search);
        
        $search['user'] = Users_info::find()->orWhere(['IN','name', $sqlArray])->orWhere(['IN','surname', $sqlArray])->joinWith('users_avatar')->asArray()->all();
        
        $search['groups'] = Users_groups::find()->where('name_groups = :name_groups', [':name_groups' => $this->str_search])->asArray()->all();
        
        return $search;
    }
}