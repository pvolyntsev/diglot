<?php

use yii\db\Migration;
use app\models\Article;
use app\models\Paragraph;

class m160622_023900_create_article extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/article.php');
        $paragraphsTemp = require (__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/paragraphs.php');

        $article = Article::findOne([
            'title_original' => $articleTemp->title_original,
            'user_id' => $articleTemp->user_id,
        ]);
        if (!$article)
            $article = new Article;

        $article->title_original = $articleTemp->title_original;
        $article->url_original = $articleTemp->url_original;
        $article->title_translate = $articleTemp->title_translate;
        $article->url_translate = $articleTemp->url_translate;
        $article->status = 'published';
        $article->date_created = $articleTemp->date_created;
        $article->date_modified = $articleTemp->date_modified;
        $article->date_deleted = '0000-00-00 00:00:00';
        $article->date_published = $articleTemp->date_published;
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
            $paragraph = new Paragraph;
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
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/article.php');

        $article = Article::findOne([
            'title_original' => $articleTemp->title_original,
            'user_id' => $articleTemp->user_id,
        ]);
        if ($article) {
            Paragraph::deleteAll(['article_id' => $article->id]);
            $article->delete();
        }
    }
}
