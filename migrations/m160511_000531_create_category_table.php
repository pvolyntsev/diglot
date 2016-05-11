<?php

use yii\db\Migration;

/**
 * Handles the creation for table `category_table`.
 */
class m160511_000531_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'category'=>$this->string(255)->notNull()->unique(),
        ]);

        $this->addCommentOnTable('category','Категории, в которые могут попадать статьи');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
