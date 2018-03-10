<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_images_like;

class Like_user_images extends Model
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
        
        $result = Users_images_like::find()->where('id_images = :id_images', [':id_images' => $this->id])
                ->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($result){
            
            return false;
            
        }
        
        $like = new Users_images_like();

        $like->id_images = $this->id;
        $like->id_user = Yii::$app->user->id;

        $like->save();

        return true;
        
    }
}