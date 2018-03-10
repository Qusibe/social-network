<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_images;
use common\models\Users_images_comment;
use common\models\Users_friends;
use common\models\Users_images_like;

class Comment_images_user extends Model
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
            
            $users_images = Users_images::findOne(['id' => $this->id]);
            
            $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])->andWhere('id_friend = :id_friend', [':id_friend' => $users_images->id_user])->one();
            
            if($users_images->id_user == Yii::$app->user->id || $users_friends){                
                                                      
                $users_comment = new Users_images_comment();

                $users_comment->id_images = $this->id;
                $users_comment->id_user = Yii::$app->user->id;
                $users_comment->comment = $this->comment;           

                $users_comment->save();
            
            }
            
        }
        
        $data = array();
        
        $size = Users_images_comment::find()->where(['id_images' => $this->id])->count();
        
        $data['comments'] = Users_images_comment::find()->where(['id_images' => $this->id])->joinWith('users_info')->joinWith('users_avatar')->orderBy('id DESC')->limit($size - $this->size)->asArray()->all();
        
        $data['like'] = Users_images_like::find()->where(['id_images' => $this->id])->count();
        
        return $data;
    }
}
