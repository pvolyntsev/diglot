<?php
namespace app\commands;

use app\models\Language;
use budyaga\users\models\User;
use yii\console\Controller;
use yii\db\Expression;

class ArticleController extends Controller
{
    public function actionSeed($count = 1)
    {
        for ($i=0; $i<$count; $i++) {
			$faker =\Faker\Factory::create();
			$article = new \app\models\Article;
			$article->title_original=$faker->text(80);
			$article->title_translate=$faker->text(80);
			$article->user_id='2';
			$article->lang_original_id='2';
			$article->lang_translate_id='1';
			$article->save();
			var_export($article->errors);
		}
		echo (" created"." ".$count." "."articles ");
	}

	/**
	 * Функция обновления всего индекса в ElasticSearch
	 *
	 */
	public function updateElastic()
	{

	}
	/**
	 * Функция удаления всего индекса в ElasticSearch
	 *
	 */
	public function deleteElastic()
	{

	}
}
