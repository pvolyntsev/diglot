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
		$article = new \app\models\Article;
		$article->title_original='Analysis Paralysis: Over-thinking and Knowing Too Much to Just CODE';
		$article->url_original='http://www.hanselman.com/blog/AnalysisParalysisOverthinkingAndKnowingTooMuchToJustCODE.aspx';
		$article->title_translate='Паралич анализа: вы знаете слишком много, чтобы просто писать код';
		$article->url_translate='https://habrahabr.ru/post/218345/';
		$article->status='published';
		$article->date_created=NULL;
		$article->date_modified=NULL;
		$article->date_deleted=time();
		$article->date_published=NULL;
		$article->user_id=1;
		$article->author_name='Scott Hanselman';
		$article->author_url='http://hanselman.com/about';
		$article->own_original=0;
		$article->translator_name='@a553';
		$article->translator_url='https://habrahabr.ru/users/a553/';
		$article->own_translate=0;
		$article->lang_original_id=1;
		$article->lang_translate_id=2;
		if (!$article->save())
            {
                var_export($article->errors);
                return -1;
            }
		$paragraphs = require (__DIR__ . '/../assets/fixtures/article/over-thinking_and_knowing_too_much_to_just_code/paragraphs.php');
		for($j=0; $j<count($paragraphs); $j++)
		{
			$paragraph = new \app\models\Paragraph;
			$paragraph->article_id = $article->id;
			$paragraph->sortorder = $j+1;
			$paragraph->paragraph_original = $paragraphs[$j]->paragraph_original;
			$paragraph->paragraph_translate = $paragraphs[$j]->paragraph_translate;
			$paragraph->date_modified = time();
			if (!$paragraph->save())
			{
				var_export($paragraph->errors);
				return -1;
			}
		}
		
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
		$article = \app\models\Article::findOne([
			'title_original' => 'Analysis Paralysis: Over-thinking and Knowing Too Much to Just CODE',
			'user_id' => 1]);
		if ($article) {     
			\app\models\Paragraph::deleteAll(['article_id' => $article->id]);
			$article->delete();
		}
    }
}
