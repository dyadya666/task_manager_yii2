<?php

namespace app\models;

use yii\db\ActiveRecord;


class Tasks extends ActiveRecord{

    public static function tableName(){
        return 'tasks';
    }

    public function rules(){
        return [
            [['projects_id'], 'number'],
            [['content'], 'string'],
            [['on_off'], 'boolean']
        ];
    }

}