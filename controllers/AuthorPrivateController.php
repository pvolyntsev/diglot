<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Article;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\web\NotFoundHttpException;

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
		
		$count = $articleDataProvider->getCount();// получаем количество элементов массива $articleDataProvider для текущей страницы
		if ( $count != null) {
			return $this->render('drafts', [
				'articles' => $articleDataProvider
			]);
		}
		else {
            throw new NotFoundHttpException('The draft articles does not exist.');
        }
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