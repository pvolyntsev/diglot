<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tag_of_article_table`.
 */
class m160510_225512_create_tag_of_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag_of_article', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('tag_of_article', 'Ключевые слова, по которым пользователи будут искать статьи');

        $this->createIndex ( 'tag_of_article_tag', 'tag_of_article', ['id','tag_id'], $unique = true );

        $this->addForeignKey('fk_tagOfarticle_tag','tag_of_article','tag_id','tag','id',$delete=null,$update=null);

        $this->addForeignKey('fk_tagOfArticle_article','tag_of_article','article_id','article','id',$delete=null,$update=null);
    }
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag_of_article');
    }
}
