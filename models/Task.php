<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property timestamp $updated_at
 * @property timestamp $created_at
 *
 * @property TaskToUser[] $taskToUsers
 */
class Task extends \yii\db\ActiveRecord
{
    public $userID;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'userID'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if (isset($insert)) {
            $taskToUser = new TaskToUser();
            $taskToUser->taskID = $this->id;
            $taskToUser->userID = $this->userID;
            $taskToUser->type = 'CREATE';
            $taskToUser->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskToUsers()
    {
        return $this->hasMany(TaskToUser::className(), ['taskID' => 'id']);
    }

    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'userID']);
    }
}
