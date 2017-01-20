<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task_to_user`.
 */
class m170119_135124_create_task_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('task_to_user', [
            'id' => $this->primaryKey(),
            'userID' => $this->integer()->notNull(),
            'taskID' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',
        ]);

        $this->createIndex(
            'idx-task_to_user-userID',
            'task_to_user',
            'userID'
        );


        $this->addForeignKey(
            'fk-task_to_user-userID',
            'task_to_user',
            'userID',
            'users',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-task_to_user-taskID',
            'task_to_user',
            'taskID'
        );

        
        $this->addForeignKey(
            'fk-task_to_user-taskID',
            'task_to_user',
            'taskID',
            'tasks',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('task_to_user');
    }
}
