<?php

namespace app\commands;

use yii\console\Controller;

class ArticleSeedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
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
                    var_export($paragraph->errors);
                    return -1;
                }
            }
        }
    }
}
