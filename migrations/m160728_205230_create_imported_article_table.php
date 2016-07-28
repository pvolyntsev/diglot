<?php

use yii\db\Migration;

/**
 * Handles the creation for table `imported_article`.
 */
class m160728_205230_create_imported_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('imported_article', [
            'id' => $this->primaryKey(),
            'imported_repo_id' => $this->integer(),
            'repo_article_path' => $this->string(),
            'article_id' => $this->integer()
        ]);
        
        $this->addForeignKey('fk_imported_article_article', 'imported_article', 'article_id', 'article' , 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_imported_article_article','imported_article');
        $this->dropTable('imported_article');
    }
}
