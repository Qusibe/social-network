<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_groups;
use yii\helpers\Url;

class Editing_Groups_Form extends Model
{
    public $file;
    public $description_groups;
    public $id_groups;
    
    public function rules()
    {
        return [
            ['id_groups', 'required'],           
            ['id_groups','integer'],
            
            [['file'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 1, 'skipOnEmpty' => true],
            
            ['description_groups', 'string']           
        ];
    }   
    
     public function Editing()
    {      
       $users_groups = Users_groups::findOne(['id' => $this->id_groups]);
       
       if($users_groups->id_user != Yii::$app->user->id){
           
           return false;
           
       }
       
       if(!empty($this->description_groups)){
                
            $users_groups->description = $this->description_groups;

        }
       
       if($this->file){
           
            $filename=Yii::$app->getSecurity()->generateRandomString(15);

            $this->file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $this->file->extension);

            $newfile = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/images/" . $this->id_groups . "/" . $filename . "." . $this->file->extension;

            $path = dirname(dirname(__DIR__)) . "/frontend/web/groups_content/temp/" . $filename . '.' . $this->file->extension;

            copy($path, $newfile);

            unlink($path);

            $way_file = Url::to("@web/groups_content/images/") . $this->id_groups . "/" . $filename . '.' . $this->file->extension;

            unlink('C:/Apache24/htdocs' . $users_groups->way_images);
            
            $users_groups->way_images = $way_file;

       }
       
       $users_groups->save();
    
       return true;
    }
      
}