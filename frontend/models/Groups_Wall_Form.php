<?php

namespace frontend\models;
 
use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Url;
use common\models\Groups_wall;
use common\models\Users_groups;
 
class Groups_Wall_Form extends Model
{
    public $id_groups; 
    public $groups_file; 
    public $message;        
 
    public function rules()
    {
        return [
            ['id_groups', 'required'],
            
            ['id_groups','integer'], 
            
            [['groups_file'], 'file', 'extensions' => 'png, jpg, mp4, mp3', 'maxFiles' => 1, 'skipOnEmpty' => true],
            
            ['message', 'string', 'max' => 255]                                 
        ];
    }
   
    public function upload()
    {        
        if (!$this->validate()) { 
            
            return false;
            
        }
        
        if(Yii::$app->user->isGuest){
                      
           return false;
            
        }
        
        $usergroups = Users_groups::find()->where('id = :id', [':id' => $this->id_groups])->andWhere('id_user = :id_user', [':id_user' => Yii::$app->user->id])->one();
       
        if($usergroups){                      
        
            if(empty($this->message) && ! $this->groups_file){

                return false;

            }

            $groupswall = new Groups_wall();
            $groupswall->id_groups = $this->id_groups;
            $groupswall->id_user = Yii::$app->user->id;

            if(!empty($this->message)){

                $groupswall->message = $this->message;

            }

            foreach ($this->groups_file as $file) {

                if($file->extension === 'png' || $file->extension === 'jpg'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/images/" . $this->id_groups . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $groupswall->way_file = Url::to("@web/groups_content/images/") . $this->id_groups . "/" . $filename . '.' . $file->extension;

                    $groupswall->format = "images";

                }

                if($file->extension === 'mp4'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/video/" . $this->id_groups . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $groupswall->way_file = Url::to("@web/groups_content/video/") . $this->id_groups . "/" . $filename . '.' . $file->extension;

                    $groupswall->format = "video";

                }

                if($file->extension === 'mp3'){

                    $filename=Yii::$app->getSecurity()->generateRandomString(15);

                    $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension);

                    $newfile = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/audio/" . $this->id_groups . "/" . $filename . "." . $file->extension;

                    $path = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $file->extension;

                    copy($path, $newfile);

                    unlink($path);

                    $groupswall->way_file = Url::to("@web/groups_content/audio/") . $this->id_groups . "/" . $filename . '.' . $file->extension;

                    $groupswall->format = "audio";

                }

            }                   

            $groupswall->save();

            return true;
        
        }else{
            
            return false;
            
        }
        
    }
     
}