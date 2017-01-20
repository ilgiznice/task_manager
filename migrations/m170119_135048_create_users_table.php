<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170119_135048_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'created_at' => $this->dateTime() . ' DEFAULT NOW()',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
