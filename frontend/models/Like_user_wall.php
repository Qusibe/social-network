<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_wall_like;

class Like_user_wall extends Model
{
    public $id;   
    
    public function rules()
    {
        return [       
            ['id', 'required'],
            ['id','integer']
        ];
    }   
    
    public function Like()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $result = Users_wall_like::find()->where('id_wall = :id_wall', [':id_wall' => $this->id])
                ->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($result){
            
            return false;
            
        }
        
        $like = new Users_wall_like();

        $like->id_wall = $this->id;
        $like->id_user = Yii::$app->user->id;

        $like->save();

        return true;
        
    }
}