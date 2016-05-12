<?php
namespace app\commands;

use yii\console\Controller;

class ArticleController extends Controller
{
    public function actionSeed()
    {
        $faker = \Faker\Factory::create();

        $article = new \app\models\Article;
        $article->title_original = $faker->text(80);
        $article->title_translate = $faker->text(80);
        $article->user_id = 1;
        $article->lang_original_id = 1;
        $article->lang_transtate_id = 2;

        if (!$article->save())
            var_export($article->errors);
    }
}
