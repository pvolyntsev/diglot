<?php

use yii\db\Migration;

/**
 * Handles the creation for table `language_table`.
 */
class m160507_184604_create_language_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('language', [
            'id' => $this->primaryKey(),
            'language'=>$this->string(255).' not null',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('language');
    }
}
