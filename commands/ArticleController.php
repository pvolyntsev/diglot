<?php
namespace app\commands;

use yii\console\Controller;
use molchanovvg\ping\Ping;
use yii;

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
        $fakerRus = \Faker\Factory::create('ru_RU');
        $fakerRusText = new \Faker\Provider\ru_RU\Text($faker);

        for ($i=0; $i<$articles; $i++)
        {
            $article = new \app\models\Article;
            $article->title_original=$faker->text(80);
            $article->title_translate=$fakerRusText->realText(80);
            $article->user_id=3;
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
                $paragraph->paragraph_translate = $fakerRusText->realText(400);
                if (!$paragraph->save())
                {
                    echo "Error during paragraph add: ";
                    var_export($paragraph->errors);
                    return -1;
                }
            }
			
			for ($nCat = 1; $nCat <= 3; $nCat++) //привязываем созданную статью к трём категориям
			{
				$articleCat = new \app\models\CategoryOfArticle;
				$articleCat->category_id = $nCat;
				$articleCat->article_id = $article->id;
			}
			if (!$articleCat->save())
			{
				echo "Error during category add: ";
                var_export($articleCat->errors);
                return -1;
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
			if (!(\app\elastic\models\Article::updateIndex($article)))
			{
				echo "Method not work\n";
			};
		}
	}

    /**
     * Список записей из индекса
     */
    public function actionViewElastic()
    {
        $query = \app\models\Article::find();
        $articles = $query->all();
        foreach($articles as $article)
        {
            \app\elastic\models\Article::viewIndex($article);
        }
    }
	/**
	 * Удаление всего индекса в ElasticSearch
	 *
	 */
	public function actionDeleteElastic()
	{
		$query = \app\models\Article::find();
		$articles = $query->all();
		foreach($articles as $article)
		{
			if (!(\app\elastic\models\Article::deleteIndex($article)))
			{
				echo 'Method not work';
			};
		}
	}

    /**
     * Удаляем индекс через curl
     */
    public function actionDeleteIndexInCurl()
    {
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'localhost:9200/diglot?pretty');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, 'http://localhost:9200/_cat/indices?v');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            echo $out;
            curl_close($curl);
        }
    }

    /**
     * Оповещаем Google и Yandex о новой статье
     */
    public function actionSendPingator()
    {
        $pingator = new Ping();
        $pingator->send('diglot','http://diglot.ru','http://diglot.ru','',"UTF-8", Yii::$app->components['yii2-pingator']['servers']);

    }
}
