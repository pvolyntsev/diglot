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
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/over-thinking_and_knowing_too_much_to_just_code/article.php');
        $paragraphsTemp = require (__DIR__ . '/../assets/fixtures/article/over-thinking_and_knowing_too_much_to_just_code/paragraphs.php');

        $article = new \app\models\Article;
        $article->title_original = $articleTemp->title_original;
        $article->url_original = $articleTemp->url_original;
        $article->title_translate = $articleTemp->title_translate;
        $article->url_translate = $articleTemp->url_translate;
        $article->status = 'published';
        $article->date_created = date("c");
        $article->date_modified = date("c");
        $article->date_deleted = '0000-00-00 00:00:00';
        $article->date_published = date("c");
        $article->user_id = $articleTemp->user_id;
        $article->author_name = $articleTemp->author_name;
        $article->author_url = $articleTemp->author_url;
        $article->own_original = $articleTemp->own_original;
        $article->translator_name = $articleTemp->translator_name;
        $article->translator_url = $articleTemp->translator_url;
        $article->own_translate = $articleTemp->own_translate;
        $article->lang_original_id = $articleTemp->lang_original_id;
        $article->lang_translate_id = $articleTemp->lang_translate_id;
        if (!$article->save())
        {
            var_export($article->errors);
            return false;
        }

        $sortorder = 0;
        foreach($paragraphsTemp as $paragraphTemp)
        {
            $paragraph = new \app\models\Paragraph;
            $paragraph->article_id = $article->id;
            $paragraph->sortorder = ++$sortorder;
            $paragraph->paragraph_original = $paragraphTemp->paragraph_original;
            $paragraph->paragraph_translate = $paragraphTemp->paragraph_translate;
            $paragraph->date_modified = date("c");
            if (!$paragraph->save())
            {
                var_export($paragraph->errors);
                return false;
            }
        }
		
		$this->insert('article', [
			'id' => 1,
			'title_original' => 'Analysis Paralysis: Over-thinking and Knowing Too Much to Just CODE',
			'url_original' => 'http://www.hanselman.com/blog/AnalysisParalysisOverthinkingAndKnowingTooMuchToJustCODE.aspx',
			'title_translate' => 'Паралич анализа: вы знаете слишком много, чтобы просто писать код',
			'url_translate' => 'https://habrahabr.ru/post/218345/',
			'status' => 'published',
			'date_created' => 1463696151,
			'date_modified' => 1463696151,
			'date_deleted' => NULL,
			'date_published' => 1463696151,
			'user_id' => 1,
			'author_name' => 'Scott Hanselman',
			'author_url' => 'http://hanselman.com/about',
			'own_original' => false,
			'translator_name' => '@a553',
			'translator_url' => 'https://habrahabr.ru/users/a553/',
			'own_translate' => false,
			'lang_original_id' => 1,
			'lang_transtate_id' => 2,
		]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/over-thinking_and_knowing_too_much_to_just_code/article.php');

        $article = \app\models\Article::findOne([
            'title_original' => $articleTemp->title_original,
            'user_id' => $articleTemp->user_id,
		
		$this->delete('article', [
            'title_original' => 'Analysis Paralysis: Over-thinking and Knowing Too Much to Just CODE',
			'user_id' => 1

        ]);
		
        if ($article) {
            \app\models\Paragraph::deleteAll(['article_id' => $article->id]);
            $article->delete();
        }
    }
}
