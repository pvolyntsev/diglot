<?php

use yii\db\Migration;

class m160622_024513_paragraph_empty extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->alterColumn('paragraph', 'paragraph_original', $this->text());
        $this->db->getSchema()->refresh();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}



