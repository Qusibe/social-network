<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Users_info;
use common\models\Users_avatar;
use common\models\Like_avatar;
use yii\helpers\Url;

class Editing_Form extends Model
{
    public $name;
    public $surname;
    public $quote;
    public $gender;
    public $hometown;
    public $day;
    public $month;
    public $year;
    public $city;
    public $activity;
    public $interests;
    public $favoritemusic;
    public $highschool;
    public $faculty;
    public $formoftraining;
    public $status;
    public $schools;
    public $file;
    
    public function rules()
    {
        return [
            ['name', 'safe'],
            ['surname', 'safe'],
            ['quote', 'safe'],
            ['gender', 'safe'],
            ['hometown', 'safe'],
            ['day', 'safe'],
            ['month', 'safe'],
            ['year', 'safe'],
            ['city', 'safe'],
            ['activity', 'safe'],
            ['interests', 'safe'],
            ['favoritemusic', 'safe'],
            ['highschool', 'safe'],
            ['faculty', 'safe'],
            ['formoftraining', 'safe'],
            ['status', 'safe'],
            ['schools', 'safe'],
            ['file', 'safe'],
        ];
    }   
    
     public function Editing()
    {
       if (!$this->validate()) {
            
           return false;
            
       }
       
       if($this->file){
       
            $path = dirname(dirname(__DIR__)) . "/frontend/web/users_content/temp/";

            $this->file->saveAs( $path . $this->file);

            $newName = Yii::$app->security->generateRandomString() . '_' . time();

            $newfile = dirname(dirname(__DIR__)) . "/frontend/web/users_content/users_images/" . Yii::$app->user->id . "/" . $newName . '.' . $this->file->extension;

            copy($path . $this->file, $newfile);

            unlink($path . $this->file);

            $useravatar = Users_avatar::findOne(['id_user' => Yii::$app->user->id]);

            if($useravatar->avatar != 'site_content/images/default_avatar.png'){
            
                unlink('C:/Apache24/htdocs' . $useravatar->avatar);
            
            }
            
            $useravatar->avatar = Url::to("@web/users_content/users_images/") . Yii::$app->user->id . "/" . $newName . '.' . $this->file->extension;
            
            $useravatar->save();
            
            Like_avatar::deleteAll('id_images = :id_images', [':id_images' => Yii::$app->user->id]);

       }
        
        $users_info = Users_info::findOne(['id_user' => Yii::$app->user->id]);
        
       if(!empty($this->name)){
                
            $users_info->name = $this->name;

        }

        if(!empty($this->surname)){

            $users_info->surname = $this->surname;

        }

        if(!empty($this->quote)){

            $users_info->quote = $this->quote;

        }

        if(!empty($this->gender)){

            $users_info->gender = $this->gender;

        }

        if(!empty($this->hometown)){

            $users_info->hometown = $this->hometown;

        }

        if(!empty($this->day) && !empty($this->month) && !empty($this->year)){

            $users_info->birthday = $this->day . " "  . $this->month . " " . $this->year . "г";

        }

        if(!empty($this->city)){

            $users_info->city = $this->city;

        }

        if(!empty($this->activity)){

            $users_info->activity = $this->activity;

        }

        if(!empty($this->interests)){

            $users_info->interests = $this->interests;

        }

        if(!empty($this->favoritemusic)){

            $users_info->favoritemusic = $this->favoritemusic;

        }

        if(!empty($this->highschool)){

            $users_info->highschool = $this->highschool;

        }

        if(!empty($this->faculty)){

            $users_info->faculty = $this->faculty;

        }

        if(!empty($this->formoftraining)){

            $users_info->formoftraining = $this->formoftraining;

        }

        if(!empty($this->status)){

            $users_info->status = $this->status;

        }

        if(!empty($this->schools)){

            $users_info->schools = $this->schools;

        }


        $users_info->save();

       
       return true;
    }
      
}