<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use yii\helpers\Url;

class Create_groups extends Model
{
    public $name_groups; 
    public $images_groups; 
    public $description_groups;   
    
    public function rules()
    {
        return [
          ['name_groups', 'string', 'max' => 255],
          [['images_groups'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 1, 'skipOnEmpty' => true],
          ['description_groups', 'string']
        ];
    }   
    
     public function Create()
    {    
       if(Yii::$app->user->isGuest ){
            
           return false;
           
       }
       
       $way_file = '';
       
       $usergroups = new Users_groups();          
       
       $usergroups->id_user = Yii::$app->user->id;
       $usergroups->name_groups = $this->name_groups;
       $usergroups->description = $this->description_groups;
       
       $usergroups->way_images = $way_file;             

       $usergroups->save();
       
       mkdir("groups_content/images/". $usergroups->id . "/");

       mkdir("groups_content/audio/". $usergroups->id . "/");

       mkdir("groups_content/video/". $usergroups->id . "/");
    
        if($this->images_groups->extension === 'png' || $this->images_groups->extension === 'jpg'){

            $filename=Yii::$app->getSecurity()->generateRandomString(15);

            $this->images_groups->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $this->images_groups->extension);

            $newfile = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/images/" . $usergroups->id . "/" . $filename . "." . $this->images_groups->extension;

            $path = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $this->images_groups->extension;

            copy($path, $newfile);

            unlink($path);

            $way_file = Url::to("@web/groups_content/images/") . $usergroups->id . "/" . $filename . '.' . $this->images_groups->extension;

        }
                   
       $usergroups->way_images = $way_file;             

       $usergroups->save();
            
       return true;
    }
      
}