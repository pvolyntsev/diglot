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
        return ['id', 'title_original', 'title_translate'];
    }

    public function rules()
    {
        return [
            ['id', 'required'],
            ['title_original', 'required'],
            ['title_translate', 'required']
        ];
    }
    public static function updateIndex(\app\models\Article $article)
    {
        try {
            $elArticle = \app\elastic\models\Article::findOne(['id' => $article->id]);
            if (!$elArticle) {
                $elArticle = new \app\elastic\models\Article();
            }
            $elArticle->attributes = [
                'id' => $article->id,
                'title_original' =>$article->title_original,
                'title_translate' =>$article->title_translate
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

