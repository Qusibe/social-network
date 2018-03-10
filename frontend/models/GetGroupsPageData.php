<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use common\models\Participants_groups;
use common\models\Groups_wall;

class GetGroupsPageData extends Model
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
        
      $data['user_groups'] = Users_groups::find()->where('id = :id', [':id' => $this->id])->orderBy('id DESC')->joinWith('users_info')->joinWith('users_avatar')->one();
        
      if(!Yii::$app->user->isGuest){
          
          if($data['user_groups']->id_user == Yii::$app->user->id){
              
              $data['user_status'] = 'this';
              
              $data['subscribers'] = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id])->andWhere('participants_groups.status = :status', [':status' => 1])->joinWith('users_info')->joinWith('users_avatar')->asArray()->all();
              
          }else{
              
               $userparticipants = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
        
              if($userparticipants){
                  
                  if($userparticipants->status == 0){
                      
                      $data['user_status'] = 'participants';
                      
                  }elseif($userparticipants->status == 1){
                      
                      $data['user_status'] = 'subscribers';
                      
                  }
                  
                  
              }else{
                  
                  $data['user_status'] = 'user';
                  
              }
              
          }
          
      }else{
          
          $data['user_status'] = 'unauthorized';
          
      }            
      
      $data['participants'] = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id])->andWhere('participants_groups.status = :status', [':status' => 0])->joinWith('users_info')->joinWith('users_avatar')->asArray()->limit(4)->all();
              
      $data['groups_wall'] = Groups_wall::find()->where('groups_wall.id_groups = :id_groups', [':id_groups' => $this->id])
                ->joinWith('users_info')->joinWith('users_avatar')->joinWith('groups_wall_like')->asArray()->orderBy('id DESC')->all();
      
       return $data;
    }
}
