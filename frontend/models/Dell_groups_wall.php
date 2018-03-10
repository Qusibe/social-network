<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Groups_wall;
use common\models\Groups_wall_comments;
use common\models\Groups_wall_like;

class Dell_groups_wall extends Model
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
        
        $groups_wall = Groups_wall::find()->where('id = :id', [':id' => $this->id_wall])->one();
      
        if($groups_wall){
            
            if($groups_wall->id_user == Yii::$app->user->id){
                
                if($groups_wall->way_file){
                
                    unlink('C:/Apache24/htdocs' . $groups_wall->way_file);
                
                }
                
                Groups_wall_like::deleteAll('id_wall = :id_wall', [':id_wall' => $this->id_wall]);
                
                Groups_wall_comments::deleteAll('id_wall = :id_wall', [':id_wall' => $this->id_wall]);
                
                $groups_wall->delete();
                
                return true;
            }
            
        }
        
        return false;
        
    }
}