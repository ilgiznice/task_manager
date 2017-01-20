<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    /**
     * @SWG\Get(
     *     path="/users",
     *     description="Get list of users",
     *     produces={"application/xml"},
     * )
     */
    public function index() {}

    /**
     * @SWG\Post(
     *     path="/users",
     *     description="Create a new user",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="User name",
     *         required=true,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="User email",
     *         required=true,
     *         type="sting",
     *     ),
     * )
     */
    public function create() {}

    /**
     * @SWG\Put(
     *     path="/users/<id>",
     *     description="Update user",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="name",
     *         in="body",
     *         description="User name",
     *         required=false,
     *         type="sting",
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="body",
     *         description="User email",
     *         required=false,
     *         type="sting",
     *     ),
     * )
     */
    public function update() {}

    /**
     * @SWG\Get(
     *     path="/users/<id>",
     *     description="Get user",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function view() {}

    /**
     * @SWG\Get(
     *     path="/users/<id>/tasks",
     *     description="Get user tasks",
     *     produces={"application/xml"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *     ),
     * )
     */
    public function actionTasks($id) {
        $user = $this->findOne($id);
        return $user->getTasks()->all();
    }

    private function findOne($id) {
        $user = User::findOne($id);
        if (isset($user)) {
            return $user;
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }
}
