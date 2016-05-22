<?php

use yii\db\Migration;

/**
 * Handles adding fk_languages to table `article`.
 */
class m160512_021254_add_fk_languages_to_article extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addForeignKey('fk_language_origin_article','article','lang_original_id','language','id',$delete=null,$update=null);

        $this->addForeignKey('fk_language_translate_article','article','lang_translate_id','language','id',$delete=null,$update=null);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_language_origin_article','article');

        $this->dropForeignKey('fk_language_translate_article','article');
    }
}
