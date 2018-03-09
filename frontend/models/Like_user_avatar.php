<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Like_avatar;

class Like_user_avatar extends Model
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
        
        $result = Like_avatar::find()->where('id_images = :id_images', [':id_images' => $this->id])
                ->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($result){
            
            return false;
            
        }
        
        $like = new Like_avatar();

        $like->id_images = $this->id;
        $like->id_user = Yii::$app->user->id;

        $like->save();

        return true;
        
    }
}