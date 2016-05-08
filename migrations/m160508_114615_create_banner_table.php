<?php

use yii\db\Migration;

/**
 * Handles the creation for table `banner_table`.
 */
class m160508_114615_create_banner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('banner', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->comment('Текст баннера в формате HTML')->notNull(),
            'position'=>$this->string(50)->notNull()->comment('Позиция баннера на странице'),
        ]);

        $this->addCommentOnTable('banner','Баннеры');
        $this->createIndex('idx_banner_position','banner','position',$unique=false);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropCommentFromTable('banner');
        $this->dropIndex('idx_banner_position','banner');
        $this->dropTable('banner');
    }
}
