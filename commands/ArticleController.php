<?php
namespace app\commands;

use app\models\Language;
use budyaga\users\models\User;
use yii\console\Controller;
use yii\db\Expression;

class ArticleController extends Controller
{
    public function actionSeed($count)
    {
        $faker = \Faker\Factory::create();

            $language = new \app\models\Language();
            $article = new \app\models\Article;

        //Delete all data from article
            $article->deleteAll();

        //Delete all data from language
            $language->deleteAll();

        //insert two languages to language
        $language = new \app\models\Language();

        $language->language= "russian";

        if (!$language->save())
        var_export($language->errors);

        $language = new \app\models\Language();

        $language->language= "english";

        if (!$language->save())
            var_export($language->errors);

        echo $count." russian and english languages were added to language!";



        //insert $count articles to article
        $language = new \app\models\Language();
        $user=new User;
        for ($i=1;$i<=$count;$i++)
        {
            $article = new \app\models\Article;
            $article->title_original = $faker->text(80);
            $article->title_translate = $faker->text(80);
//            $user_id=$user->findBySql('select max(id) as maxId from user')->one();
//            echo "************************".$user_id->maxId;
//            $user_id=$query = \app\models\User::find()
//                ->orderBy(new Expression('rand()'))
//                ->limit(1);
            $article->user_id = rand(1,16);

            $rus=$language->findBySql('select id from language where language=\'russian\'')->one();
            $eng=$language->findBySql('select id from language where language=\'english\'')->one();
            $article->lang_original_id =$rus->id;
            $article->lang_transtate_id = $eng->id;

            if (!$article->save())
            var_export($article->errors);
        }

        echo $count." articles are created! Congratulates!";
    }
}
