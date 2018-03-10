<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_images;
use yii\helpers\Url;

class Add_images extends Model
{
    public $imageFiles;   
    
    public function rules()
    {
        return [            
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4,'checkExtensionByMimeType'=>false]
        ];
    }   
    
    public function Add()
    {
        if(Yii::$app->user->isGuest){
            
            return false;
            
        }
        
        if ($this->validate()) { 
                                                             
            foreach ($this->imageFiles as $file) {
                
                $filename=Yii::$app->getSecurity()->generateRandomString(15);
                
                $file->saveAs(dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension);
                
                $newfile = dirname(dirname(__DIR__)) . "/frontend/web/users_content/users_images/". Yii::$app->user->id . "/" . $filename . "." . $file->extension;
                
                $path = dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/" . $filename . '.' . $file->extension;
                
                copy($path, $newfile);

                unlink($path);
                
                $userimages = new Users_images();
                $userimages->id_user = Yii::$app->user->id;       
                $userimages->way_images = Url::to("@web/users_content/users_images/") . Yii::$app->user->id . "/" . $filename . '.' . $file->extension;
                
                $userimages->save();
                
            }
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
}
