<?php

use yii\db\Migration;

/**
 * Handles the creation for table `article_table`.
 */
class m160508_091836_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title_original'=>$this->string(100)->notNull(),
            'url_original'=>$this->string(500).' null',
            'title_translate'=>$this->string(100),
            'url_translate'=>$this->string(500).' null',
            //'status'=>$this->enum('draft', 'published', 'blocked')->notNull()->defaultValue('draft')->comment('Статуc'),
            'status'=>"enum('draft', 'published', 'blocked') NOT NULL DEFAULT 'draft' COMMENT 'Статуc'",
            'date_created'=>$this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'date_modified'=>$this->timestamp()->notNull()." DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
            'date_deleted'=>$this->timestamp()->defaultValue('0000-00-00 00:00:00'),
            'date_published'=>$this->timestamp()->defaultValue('0000-00-00 00:00:00'),
            'user_id'=>$this->integer()->notNull(),
            'author_name'=>$this->string(255),
            'author_url'=>$this->string(500),
            'own_original'=>$this->integer()->defaultValue(0)->comment('Собственная оригинальная статья'),
            'translator_name'=>$this->string(255),
            'translator_url'=>$this->string(500),
            'own_translate'=>$this->integer()->notNull()->defaultValue(0)->comment('Собственный перевод'),
            'lang_original_id'=>$this->integer()->notNull()->comment('Язык оригинальной статьи'),
            'lang_translate_id'=>$this->integer()->comment('Язык перевода'),
        ]);

        $this->addForeignKey('fk_article_user','article','user_id','user','id',$delete=null,$update=null);
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
