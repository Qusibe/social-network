<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;

class Del_user_groups extends Model
{
    public $id_user;   
    public $id_groups; 
    
    public function rules()
    {
        return [      
            ['id_user', 'required'],           
            ['id_user','integer'],
            
            ['id_groups', 'required'],           
            ['id_groups','integer']
       
        ];
    }   
    
    public function Delete()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $users_groups = Users_groups::find()->where('id = :id', [':id' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($users_groups){
            
            $participants_groups = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id_groups])
                ->andWhere('id_user = :id_user', [':id_user' => $this->id_user])->one();
            
            if($participants_groups){
                
                $participants_groups->delete();
                
                return true;
                
            }else{
                
                return false;
                
            }
            
        }
      
        
        return false;
        
    }
}
