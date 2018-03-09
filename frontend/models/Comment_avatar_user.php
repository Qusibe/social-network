<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_avatar;
use common\models\Users_avatar_comment;
use common\models\Users_friends;

class Comment_avatar_user extends Model
{
    public $id;   
    public $size;
    public $comment;
    
    public function rules()
    {
        return [            
            ['id', 'required'],
            ['id','integer'],
            
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
            
            $users_avatar = Users_avatar::findOne(['id_user' => $this->id]);
            
            $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere('id_friend = :id_friend', [':id_friend' => $users_avatar->id_user])->one();
            
            if($users_avatar->id_user == Yii::$app->user->id || $users_friends){                
                                                      
                $users_comment = new Users_avatar_comment();

                $users_comment->id_avatar = $this->id;
                $users_comment->id_user = Yii::$app->user->id;
                $users_comment->comment = $this->comment;           

                $users_comment->save();
            
            }
            
        }
        
        $data = array();
        
        $size = Users_avatar_comment::find()->where(['id_avatar' => $this->id])->count();
        
        $data['comments'] = Users_avatar_comment::find()->where(['id_avatar' => $this->id])->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->limit($size - $this->size)->asArray()->all();
        
        return $data;
    }
}
