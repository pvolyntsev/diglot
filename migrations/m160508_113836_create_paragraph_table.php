<?php

use yii\db\Migration;

/**
 * Handles the creation for table `paragraph_table`.
 */
class m160508_113836_create_paragraph_table extends Migration
{
    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('paragraph', [
            'id' => $this->primaryKey(),
            'article_id'=>$this->integer()->notNull(),
            'paragraph_original'=>$this->text()->notNull(),
            'paragraph_translate'=>$this->text(),
            'date_modified'=>$this->timestamp()." DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            'sortorder'=>$this->integer()->notNull()->defaultValue(1)->comment('Порядковый номер параграфа в статье'),
        ]);

        $this->addCommentOnTable('paragraph','Абзац статьи');

        $this->createIndex('uq_para_sortorder','paragraph',['article_id','sortorder'],$unique=true);

        $this->addForeignKey('fk_paragraph_article','paragraph','article_id','article','id',$delete=null,$update=null);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('paragraph');
    }
}



