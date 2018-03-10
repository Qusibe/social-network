<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;

class Add_participants extends Model
{
    public $id_groups;  
    public $id_user;
    
    public function rules()
    {
        return [          
            ['id_groups', 'required'],           
            ['id_groups','integer'],
            
            ['id_user', 'required'],           
            ['id_user','integer']       
        ];
    }   
    
    public function Add()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $usergroups = Users_groups::find()->where('id = :id', [':id' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if(!$usergroups){
            
            return false;
            
        }
        
        if($this->id_user == Yii::$app->user->id){
            
            return false;
            
        }
        
        $userparticipants = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => $this->id_user])->one();
        
        if($userparticipants && $userparticipants->status == 1){
            
            $userparticipants->status = 0;
            
            $userparticipants->save();
            
            return true;
            
        }
        
        
        
        return false;
        
    }
}