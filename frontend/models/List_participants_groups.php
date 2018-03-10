<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;

class List_participants_groups extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id','safe']
        ];
    }   
    
    public function Get()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
        $users_groups = Users_groups::find()->where('id = :id', [':id' => $this->id])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
        if($users_groups){
            
            $data['user_status'] = 'this';
            
        }else{
            
            $data['user_status'] = 'user';
            
        }
             
        $data['participants'] = Participants_groups::find()->where('participants_groups.id_groups = :id_groups', [':id_groups' => $this->id])
                ->andWhere('participants_groups.status = :status', [':status' => 0])->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->asArray()->all(); 
          
       return $data;
    }
}
