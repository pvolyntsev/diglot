<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Article;
use yii\data\ActiveDataProvider;
use app\models\User;

class AuthorPrivateController extends Controller
{
    public $layout = 'author-private';
	
    /**
     * Список черновиков автора
     */
	
	public function actionDrafts()
    {
        $articleDataProvider = new ActiveDataProvider([
            'query' => Article::find()
                    ->where('status=:draft and user_id=:author_id',
                        [
                            ':draft' => 'draft',
                            ':author_id' => Yii::$app->user->identity->id
                        ]),
            //sort
            'sort' => [
                'defaultOrder' => [
                    'date_created' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('drafts', [
            'articles' => $articleDataProvider
        ]);
    }
	
    /**
     * Список комментариев на проверку
     */
    public function actionModeration()
    {
        return $this->render('moderation', [
            #'responses' => $dataProvider,
        ]);
    }
}