<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_to_user".
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $taskID
 * @property string $type
 * @property timestamp $updated_at
 * @property timestamp $created_at
 *
 * @property Tasks $task
 * @property Users $user
 */
class TaskToUser extends \yii\db\ActiveRecord
{
    const TYPE_CREATE = 'CREATE';
    const TYPE_APPLY = 'APPLY';
    const TYPE_DO = 'DO';

    static $types = [
        self::TYPE_CREATE,
        self::TYPE_APPLY,
        self::TYPE_DO,
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'taskID', 'type'], 'required'],
            [['userID', 'taskID'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['taskID'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['taskID' => 'id']],
            [['userID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userID' => 'id']],
            ['type', 'in', 'range' => self::$types],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'taskID' => 'Task ID',
            'type' => 'Type',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'taskID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userID']);
    }
}
