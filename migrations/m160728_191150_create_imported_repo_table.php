<?php

use yii\db\Migration;

/**
 * Handles the creation for table `imported_repo`.
 */
class m160728_191150_create_imported_repo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('imported_repo', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'repo_url' => $this->string(),
            'last_revision' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('imported_repo');
        return true;
    }
}
