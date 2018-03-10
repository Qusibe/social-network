<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_images;
use common\models\Users_images_comment;
use common\models\Users_images_like;

class Del_user_images extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Delete()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $users_images = Users_images::find()->where('id = :id', [':id' => $this->id])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
            
        if($users_images){
            
            unlink('C:/Apache24/htdocs' . $users_images->way_images);
            
            $users_images->delete();
            
            Users_images_comment::deleteAll('id_images = :id_images', [':id_images' => $this->id]);
            
            Users_images_like::deleteAll('id_images = :id_images', [':id_images' => $this->id]);
            
            return true;
        }
        
        
        return false;
        
    }
}
