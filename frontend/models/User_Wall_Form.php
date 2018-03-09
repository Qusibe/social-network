<?php

namespace frontend\models;
 
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Url;
use common\models\Users_wall;
use common\models\Users_friends;
 
class User_Wall_Form extends Model
{
    public $id_user; 
    public $user_file; 
    public $message;        
 
    public function rules()
    {
        return [
            
            ['id_user', 'required'],
            
            ['id_user','integer'], 
            
            [['user_file'], 'file', 'extensions' => 'png, jpg, mp4, mp3', 'maxFiles' => 1, 'skipOnEmpty' => true],
            
            ['message', 'string', 'max' => 255]                      
        ];
    }
   
    public function upload()
    {             
        if(Yii::$app->user->isGuest){
                      
           return false;
            
        }
        
        $users_friends = Users_friends::find()->where('id_user = :id_user', [':id_user' => Yii::$app->user->id])
                                        ->andWhere( 'id_friend = :id_friend', [':id_friend' => $this->id_user])->one();
        
        if($this->id_user == Yii::$app->user->id || $users_friends->status == 0){                      
        
            if(empty($this->message) && ! $this->user_file){

                return false;

            }

            $userwall = new Users_wall();
            $userwall->id_user = $this->id_user;
            $userwall->id_friend = Yii::$app->user->id;

            if(!empty($this->message)){

                $userwall->message = $this->message;

            }

            foreach ($this->user_file as $file) {

                if($file->extension === 'png' || $file->extension === 'jpg'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/users_content/wall_images/" . $this->id_user . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $userwall->way_file = Url::to("@web/users_content/wall_images/") . $this->id_user . "/" . $filename . '.' . $file->extension;

                    $userwall->format = "images";

                }

                if($file->extension === 'mp4'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/users_content/wall_video/" . $this->id_user . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $userwall->way_file = Url::to("@web/users_content/wall_video/") . $this->id_user . "/" . $filename . '.' . $file->extension;

                    $userwall->format = "video";

                }

                if($file->extension === 'mp3'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/users_content/wall_audio/" . $this->id_user . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $userwall->way_file = Url::to("@web/users_content/wall_audio/") . $this->id_user . "/" . $filename . '.' . $file->extension;

                    $userwall->format = "audio";

                }

            }                   

            $userwall->save();

            return true;
        
        }else{
            
            return false;
            
        }
        
    }
     
}