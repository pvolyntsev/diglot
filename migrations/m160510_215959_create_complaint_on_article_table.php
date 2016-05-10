<?php

use yii\db\Migration;

/**
 * Handles the creation for table `complaint_on_article_table`.
 */
class m160510_215959_create_complaint_on_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('complaint_on_article', [
            'id' => $this->primaryKey(),
            'complaint'=>$this->text()->notNull(),
            'article_id'=>$this->integer()->notNull(),
            'date_created'=>$this->timestamp()->defaultValue(('0000-00-00 00:00:00')),
            'date_deleted'=>$this->timestamp()->defaultValue(('0000-00-00 00:00:00')),
        ]);

        $this->addCommentOnTable('complaint_on_article','Жалобы на статьи');

        $this->addForeignKey('fk_complaint_article','complaint_on_article','article_id','article','id',$delete=null,$update=null);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('complaint_on_article');
    }
}
