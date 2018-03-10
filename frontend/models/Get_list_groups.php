<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;

class Get_list_groups extends Model
{
    public $id;   
    
    public function rules()
    {
        return [            
            ['id', 'required'],           
            ['id','integer']
        ];
    }   
    
    public function Get()
    {
        if (!$this->validate()) {
            
            return false;
            
        }
        
      $data['user_groups'] = $models = Users_groups::find()->where('id_user = :id_user', [':id_user' => $this->id])->orderBy('id DESC')->all();
        
      $data['participants_groups'] = Participants_groups::find()->where('participants_groups.id_user = :id_user', [':id_user' => $this->id])->andWhere('status = :status', [':status' => 0])->joinWith('users_groups')->orderBy('id DESC')->asArray()->all(); 
          
       return $data;
    }
}
