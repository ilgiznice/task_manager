<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property timestamp $updated_at
 * @property timestamp $created_at
 *
 * @property TaskToUser[] $taskToUsers
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['updated_at', 'created_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
            ['updated_at', 'default', 'value' => date('Y-m-d H:i:s')]
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
            'email' => 'Email',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskToUser()
    {
        return $this->hasMany(TaskToUser::className(), ['userID' => 'id']);
    }

    public function getTasks() {
        return $this->hasMany(TaskToUser::className(), ['userID' => 'id']);
    }
}
