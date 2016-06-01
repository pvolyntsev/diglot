<?php
namespace app\elastic\models;

use yii\db\ActiveRecord;
use yii\elasticsearch;


class Article extends elasticsearch\ActiveRecord
{

    public static function index()
    {
        return 'diglot';
    }

    public static function type()
    {
        return 'article';
    }

    public function attributes()
    {
        return ['id', 'user_id', 'status', 'title_original', 'title_translate', 'paragraphs_original', 'paragraphs_translate'];
    }

    public function rules()
    {
        return [
            ['id', 'required'],
            ['user_id', 'required'],
            ['status', 'required'],
            ['title_original', 'required'],
            ['title_translate', 'required'],
            ['paragraphs_original', 'required'],
            ['paragraphs_translate', 'required'],
        ];
    }
    public static function updateIndex(\app\models\Article $article)
    {
        try {
            $elArticle = \app\elastic\models\Article::findOne(['id' => $article->id]);
            if (!$elArticle) {
                $elArticle = new \app\elastic\models\Article();
            }
            $paragraphs_original=[];
            foreach($article->paragraphs as $parag)
            {
                $paragraphs_original[]=$parag->paragraph_original;
            }
            $paragraphs_translate=[];
            foreach($article->paragraphs as $parag)
            {
                $paragraphs_translate[]=$parag->paragraph_translate;
            }
            $elArticle->attributes = [
                'id' => $article->id,
                'user_id' => $article->user_id,
                'status' => $article->status,
                'title_original' =>$article->title_original,
                'title_translate' =>$article->title_translate,
                'paragraphs_original' => $paragraphs_original,
                'paragraphs_translate' => $paragraphs_translate,

            ];
            var_dump($elArticle);
            if (!$elArticle->save()){
                return false;
            }
            return true;
        } catch(\Exception $e)
        {
           \yii::error('Error afterSave: '.$e.' '.$elArticle->errors , 'accessElastic');
            return false;
        }
    }
    public static function deleteIndex(\app\models\Article $article)
    {
        try {
            $elArticle = \app\elastic\models\Article::findOne(['id' => $article->id]);
            if ($elArticle) {
                $elArticle->delete();
                return true;
            }
            else{
                return false;
            }
        } catch(\Exception $e)
        {
            Yii::error('Error afterDelete: '.$e.' '.$elArticle->errors, 'accessElastic');
            return false;
        }
    }
}

