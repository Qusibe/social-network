<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;

class Request_entry_groups extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Request()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
       
        $usergroups = Users_groups::find()->where('id = :id', [':id' => $this->id])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($usergroups){
            
            return false;
            
        }
        
        $userparticipants = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($userparticipants){
            
            return false;
            
        }
        
        $participantsgroups = new Participants_groups();
        
        $participantsgroups->id_groups = $this->id;
        $participantsgroups->id_user = Yii::$app->user->id;
        $participantsgroups->status = 1;// 0 учасник 1 заявка
        
        $participantsgroups->save();
        
        return true;
        
    }
}