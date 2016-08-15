<?php

use yii\db\Migration;

class m160815_200918_create_job_table extends Migration
{
    public function up()
    {
        $this->createTable('job', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
            'user_id' => $this->integer()
        ]);
    }

    public function down()
    {
        $this->dropTable('job');
        return true;
    }
}
