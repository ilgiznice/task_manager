<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tasks`.
 */
class m170119_135107_create_tasks_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tasks');
    }
}
