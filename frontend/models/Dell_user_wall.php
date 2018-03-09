<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_wall;
use common\models\Users_wall_like;

class Dell_user_wall extends Model
{
    public $id_wall;   
    
    public function rules()
    {
        return [          
            
            ['id_wall', 'required'],           
            ['id_wall','integer']
        ];
    }   
    
    public function Delete()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $users_wall = Users_wall::find()->where('id = :id', [':id' => $this->id_wall])->one();
      
        if($users_wall){
            
            if($users_wall->id_user == Yii::$app->user->id || $users_wall->id_friend == Yii::$app->user->id){
                
                if($users_wall->way_file){
                
                    unlink('C:/Apache24/htdocs' . $users_wall->way_file);
                
                }
                
                Users_wall_like::deleteAll('id_wall = :id_wall', [':id_wall' => $this->id_wall]);
                
                $users_wall->delete();
                
                return true;
            }
            
        }
        
        return false;
        
    }
}
