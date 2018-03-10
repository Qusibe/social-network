<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Groups_wall_comments;
use common\models\Participants_groups;
use common\models\Users_groups;

class Comment_wall_groups extends Model
{
    public $id;   
    public $id_groups;
    public $size;
    public $comment;
    
    public function rules()
    {
        return [      
            ['id', 'required'],
            ['id','integer'],
            
            ['id_groups', 'required'],
            ['id_groups','integer'],
            
            ['size', 'required'],
            ['size','integer'],
            
            ['comment', 'string', 'max' => 255]
                       
        ];
    }   
    
    public function Comment()
    {
        if (!$this->validate()) {
            
            return null;
            
        }
    
        if(!empty($this->comment)){
            
            if(Yii::$app->user->isGuest){

                return null;

            }
            
            $users_groups = Users_groups::find()->where('id = :id', [':id' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
          
            $participants_groups = Participants_groups::find()->where('id_groups = :id_groups', [':id_groups' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
          
            
            if($users_groups || $participants_groups && $participants_groups->status == 0){                
                                                      
                $groups_comment = new Groups_wall_comments();

                $groups_comment->id_wall = $this->id;
                $groups_comment->id_user = Yii::$app->user->id;
                $groups_comment->comment = $this->comment;           

                $groups_comment->save();
            
            }
            
        }
        
        $data = array();
        
        $size = Groups_wall_comments::find()->where(['id_wall' => $this->id])->count();
        
        $data['comments'] = Groups_wall_comments::find()->where(['id_wall' => $this->id])->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->limit($size - $this->size)->asArray()->all();
        
        return $data;
    }
}
