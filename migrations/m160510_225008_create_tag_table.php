<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tag_table`.
 */
class m160510_225008_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'tag'=>$this->string(255)->notNull()->unique(),
        ]);

        $this->addCommentOnTable('tag','Ключевые слова');
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag');
    }
}
