<?php

namespace app\models;

use yii\db\ActiveRecord;


class Projects extends ActiveRecord{

    public static function tableName(){
        return 'projects';
    }

    public function rules(){
        return [
            [['project_name'], 'string']
        ];
    }
}