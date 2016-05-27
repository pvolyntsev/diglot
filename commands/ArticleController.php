<?php
namespace app\commands;

use yii\console\Controller;

class ArticleController extends Controller
{
    /**
     * Creates articles with paragraphs
     * @param int $articles  Quantity of articles to create
     * @param int $paragraphs  Quantity of paragraphs to create for each article
     * @return int
     */
    public function actionSeed($articles = 1, $paragraphs = 1)
    {
        $faker =\Faker\Factory::create();
        for ($i=0; $i<$articles; $i++)
        {
            $article = new \app\models\Article;
            $article->title_original=$faker->text(80);
            $article->title_translate=$faker->text(80);
            $article->user_id='2';
            $article->lang_original_id='1';
            $article->lang_translate_id='2';
            if (!$article->save())
            {
                echo "Error during article add: ";
                var_export($article->errors);
                return -1;
            }
            for($j=0; $j<$paragraphs; $j++)
            {
                $paragraph = new \app\models\Paragraph;
                $paragraph->article_id = $article->id;
                $paragraph->sortorder = $j+1;
                $paragraph->paragraph_original = $faker->text(400);
                $paragraph->paragraph_translate = $faker->text(400);
                if (!$paragraph->save())
                {
                    echo "Error during paragraph add: ";
                    var_export($paragraph->errors);
                    return -1;
                }
            }

            echo 'Added article #', $article->id, ' title_original="', $article->title_original, '" title_translate="', $article->title_translate, '"', PHP_EOL;
        }
    }

	/**
	 * Функция обновления всего индекса в ElasticSearch
	 *
	 */
	public function actionUpdateElastic()
	{
		$query = \app\models\Article::find();
		$articles = $query->all();
		foreach($articles as $article)
		{
			echo $article->title_original;
			if (!(\app\elastic\models\Article::updateIndex($article)))
			{
				echo 'Method not work';
			};
		}


	}
	/**
	 * Функция удаления всего индекса в ElasticSearch
	 *
	 */
	public function actionDeleteElastic()
	{
		$query = \app\models\Article::find();
		$articles = $query->all();
		foreach($articles as $article)
		{
			echo $article->title_original;
			if (!(\app\elastic\models\Article::deleteIndex($article)))
			{
				echo 'Method not work';
			};
		}
	}
}
