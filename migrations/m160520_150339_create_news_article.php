<?php

use yii\db\Migration;
use app\models\Article;

/**
 * Handles the creation for table `news_article`.
 */
class m160520_150339_create_news_article extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {	
		$faker =\Faker\Factory::create();
		$this->insert('article', [
            'title_original' => $faker->text(50),
			'title_translate' => $faker->text(50),
			'author_name' => $faker->text(20),
			'own_original' => $faker->text(80),
			'own_translate' => $faker->text(80),
			'user_id' => '1',
			'lang_original_id' => '1',
			'lang_transtate_id' => '2'
		]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->delete('article', [
            'title_original' => $model->titleOriginal,
			'user_id' => $model->id
        ]);
    }
}
