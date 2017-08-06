<?php

namespace app\controllers;

use yii;
use app\models\Projects;
use yii\web\Response;

class ProjectsController extends yii\web\Controller{

    public $error_id = 'Wrong ID!';
    public $error_validate = 'Validate failed!';

    public function actionGetProject(){
        $id = Yii::$app->request->post('project_id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if( $id != null ){
            $project = Projects::findOne(['id = :id', [':id' => $id]]);

            if ( !$project ){
                return [
                    'success' => false,
                    'message' => $this->error_id,
                ];
            }
            return [
                'success' => true,
                'project' => $project,
            ];
        }

        $all_projects = Projects::find()->all();
        return [
            'success' => true,
            'all_projects' => $all_projects,
        ];
    }

    public function actionCreateProject(){
        $name = Yii::$app->request->post('project_name');
        $model = new Projects();
        $model->project_name = $name;
        if (!$model->validate()){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => false,
            ];
        }
        $model->save();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => true,
            'project' => $model,
        ];
    }

    public function actionUpdateProject(){
        $id = Yii::$app->request->post('project_id');
        $updated_name = Yii::$app->request->post('project_name');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($id == null){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $project = Projects::findOne(['id = :id', [':id' => $id]]);
        if ( !$project ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $project->project_name = $updated_name;

        if ( !$project->validate() ){
            return [
                'success' => false,
                'message' => $this->error_validate,
            ];
        }
        $project->save();

        return [
            'success' => true,
            'project' => $project,
        ];
    }

    public function actionDeleteProject(){
        $id = Yii::$app->request->post('project_id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( ($model = Projects::findOne(['id = :id', [':id' => $id]])) !== null ){
            $model->delete();

            return [
                'success' => true,
            ];
        }
        return [
            'success' => false,
            'message' => $this->error_id,
        ];
    }

}