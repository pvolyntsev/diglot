<?php

use yii\db\Migration;

/**
 * Handles the creation for table `comment_table`.
 */
class m160512_023205_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'article_id'=>$this->integer()->notNull(),
            'comment'=>$this->text()->notNull(),
            'date_created'=>$this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'date_modified'=>$this->timestamp()->notNull()." DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            'status'=>"enum('published', 'blocked') NOT NULL DEFAULT 'published' COMMENT 'Статуc'",
        ]);

        $this->addForeignKey('fk_comment_user','comment','user_id','user','id',$delete=null,$update=null);

        $this->addForeignKey('fk_article_article','comment','article_id','article','id',$delete=null,$update=null);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('comment');
    }
}
