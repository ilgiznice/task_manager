<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Task;
use app\models\TaskToUser;
use yii\db\Query;

class TaskController extends ActiveController
{
    public $modelClass = 'app\models\Task';

     /**
     * @SWG\Get(
     *     path="/tasks",
     *     description="Get list of tasks",
     *     produces={"application/xml"},
     * )
     */
    public function index() {}

    /**
     * @SWG\Post(
     *     path="/tasks",
     *     description="Create a new task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Task name",
     *         required=true,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="description",
     *         in="body",
     *         description="Task description",
     *         required=false,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="userID",
     *         in="body",
     *         description="Task owner",
     *         required=true,
     *         type="sting",
     *     ),
     * )
     */
    public function create() {}

    /**
     * @SWG\Put(
     *     path="/tasks/<id>",
     *     description="Update task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Task id",
     *         required=true,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="Task name",
     *         required=false,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="description",
     *         in="body",
     *         description="Task description",
     *         required=false,
     *         type="sting",
     *     ),
     * )
     */
    public function update() {}

    /**
     * @SWG\Get(
     *     path="/tasks/<id>",
     *     description="Get task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Task id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function view() {}

    /**
     * @SWG\Get(
     *     path="/tasks/<id>/contactors",
     *     description="Get list of users applied to task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Task id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function actionContractors($id) {
        $query = new Query();
        $query
            ->select(['users.name', 'users.email'])
            ->from('task_to_user')
            ->join('INNER JOIN', 'users', 'users.id=task_to_user.userID')
            ->where(['task_to_user.taskID' => $id, 'task_to_user.type' => 'APPLY']);
        $command = $query->createCommand();
        $data = $command->queryAll();
        return $data;
    }

    /**
     * @SWG\Post(
     *     path="/tasks/<id>/bind",
     *     description="Choose user to perform the task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Task id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="userID",
     *         in="body",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function actionBind($id) {
        $userID = Yii::$app->request->post('userID');
        $apply = TaskToUser::findOne(['taskID' => $id, 'userID' => $userID]);
        if (!isset($apply)) {
            throw new \yii\web\NotFoundHttpException();
        }
        $apply->type = 'DO';
        $apply->save();
        return $apply;
    }

    /**
     * @SWG\Post(
     *     path="/tasks/<id>/apply",
     *     description="Apply to the task",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="Task id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="userID",
     *         in="body",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function actionApply($id) {
        $userID = Yii::$app->request->post('userID');
        $bind = new TaskToUser([
            'taskID' => $id,
            'userID' => $userID,
            'type' => 'APPLY',
        ]);
        $bind->save();
        return $bind;
    }
}
