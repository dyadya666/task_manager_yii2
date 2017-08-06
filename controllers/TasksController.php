<?php

namespace app\controllers;

use yii;
use app\models\Tasks;
use yii\web\Response;

class TasksController{
    
    public $error_id = 'Wrong ID!';
    public $error_project_id = 'Wrong Project ID!';
    public $error_find_tasks = 'Not found any task!';
    public $error_validate = 'Validate failed!';
    
    public function actionGetOneTask(){
        $id = Yii::$app->request->post('task_id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( $id == null ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $task = Tasks::findOne(['id = :id', [':id' => $id]]);

        if ( !$task ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        return [
            'success' => true,
            'task' => $task,
        ];
    }

    public function actionGetTasks(){
        $project_id = Yii::$app->request->post('project_id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( !$project_id ){
            return [
                'success' => false,
                'message' => $this->error_project_id,
            ];
        }
        $tasks = Tasks::find()
            ->where(['project_id = :project_id', [':project_id' => $project_id]])
            ->all();
        if ( !$tasks ){
            return [
                'success' => false,
                'message' => $this->error_find_tasks,
            ];
        }
        return [
            'success' => true,
            'tasks' => $tasks,
        ];
    }
    
    public function actionCreateTask(){
        $content = Yii::$app->request->post('task_content');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Tasks();
        $model->content = $content;

        if ( !$model->validate() ){
            return [
                'success' => false,
                'message' => $this->error_validate,
            ];
        }

        $model->save();
        return [
            'success' => true,
            'task' => $model,
        ];
    }
    
    public function actionUpdateTask(){
        $id = Yii::$app->request->post('task_id');
        $updated_content = Yii::$app->request->post('task_content');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( $id == null ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $task = Tasks::findOne(['id = :id', [':id' => $id]]);
        
        if ( !$task ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $task->content = $updated_content;

        if ( !$task->validate() ){
            return [
                'success' => false,
                'message' => $this->error_validate,
            ];
        }
        $task->save();
        return [
            'success' => true,
            'task' => $task,
        ];
    }
    
    public function actionDeleteTask(){
        $id = Yii::$app->request->post('task_id');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( $id == null ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }

        if ( ($model = Tasks::findOne(['id = :id', [':id' => $id]])) ){
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

    public function actionTaskDone(){
        $id = Yii::$app->request->post('task_id');
        $on_off = Yii::$app->request->post('on_off');
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ( $id == null || $on_off = null ){
            return [
                'success' => false,
                'message' => $this->error_id,
            ];
        }
        $task = Tasks::findOne(['id = :id', [':id' => $id]]);

         if ( !$task ){
             return [
                 'success' => false,
                 'message' => $this->error_find_tasks,
             ];
         }
        $task->on_off = $on_off;

        if ( !$task->validate() ){
            return [
                'success' => false,
                'message' => $this->error_validate,
            ];
        }
        $task->save();

        return [
            'success' => true,
            'task' => $task,
        ];
    }
}