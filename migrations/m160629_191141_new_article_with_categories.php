<?php

use yii\db\Migration;
use app\models\Article;
use app\models\Paragraph;
use app\models\Category;
use app\models\CategoryOfArticle;

class m160629_191141_new_article_with_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/how_to_debug_your_brain/article.php');
        $paragraphsTemp = require (__DIR__ . '/../assets/fixtures/article/how_to_debug_your_brain/paragraphs.php');
		$categoriesTemp = require (__DIR__ . '/../assets/fixtures/article/how_to_debug_your_brain/categories.php');

        $article = Article::findOne([
            'title_original' => $articleTemp->title_original,
            'user_id' => $articleTemp->user_id,
        ]);
        if (!$article)
            $article = new Article;
		
		//$article->id = $articleTemp->id;
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
		/*
		$catIdDev = $categoriesTemp[0];
		$catIdProd = $categoriesTemp[1];
		$catIdTime = $categoriesTemp[2];
		
		$catId_1 = Yii::$app->db->createCommand("SELECT `id` FROM `category` WHERE `category` = '$catIdDev'")
							->queryScalar();
		//var_dump($catId_1);
		//return false;
		
		$this->insert('category_of_article', [
			'article_id' => $article->id,
			'category_id' => $catId_1, // Development
		]);
		
		$catId_2 = Yii::$app->db->createCommand("SELECT `id` FROM `category` WHERE `category`='$catIdProd'")
								->queryScalar();
		$this->insert('category_of_article', [
			'article_id' => $article->id,
			'category_id' => $catId_2, // Productivity
		]);
		
		$catId_3 = Yii::$app->db->createCommand("SELECT `id` FROM `category` WHERE `category`='$catIdTime'")
								->queryScalar();
		$this->insert('category_of_article', [
			'article_id' => $article->id,
			'category_id' => $catId_3, // Time Management
		]);
		*/	
		
		
		
		foreach ($categoriesTemp as $categoryTemp)
		{	
			$category = new CategoryOfArticle();
			$category->article_id = $article->id;
			$cat = $categoryTemp->category;
			$cat_id = Yii::$app->db->createCommand("SELECT `id` FROM `category` WHERE `category`='$cat'")
								->queryScalar();
			$category->category_id = $cat_id;
			
            if (!$category->save() or $cat_id=null)
            {
                var_export($category->errors);
                return false;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $articleTemp = require (__DIR__ . '/../assets/fixtures/article/how_to_debug_your_brain/article.php');

        $article = Article::findOne([
            'title_original' => $articleTemp->title_original,
            'user_id' => $articleTemp->user_id,
        ]);
        if ($article) {
			CategoryOfArticle::deleteAll(['article_id' => $article->id]);
            Paragraph::deleteAll(['article_id' => $article->id]);
            $article->delete();
        }
    }
}