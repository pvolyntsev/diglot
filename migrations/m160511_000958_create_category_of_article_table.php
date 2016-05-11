<?php
use yii\db\Migration;
/**
 * Handles the creation for table `categoryofarticle_table`.
 */
class m160511_000958_create_category_Of_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('category_of_article', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
        ]);
        $this->addCommentOnTable('category_of_article', 'Категории статьи');
        $this->createIndex('uq_category_of_article', 'category_of_article', ['article_id', 'category_id'], $unique = true);
        $this->addForeignKey('fk_category_of_article_article','category_of_article','article_id','article','id',$delete=null,$update=null);
        $this->addForeignKey('fk_category_of_article_category','category_of_article','category_id','category','id',$delete=null,$update=null);
    }
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('category_of_article');
    }
}