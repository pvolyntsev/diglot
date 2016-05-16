<?php

namespace app\controllers;

use app\models\Article;
use Yii;
use yii\web\Controller;
use app\models\Comment;

class PrototypeController extends Controller
{
    public $layout = 'prototype';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $data = [
            'entity' => '',
            'mode' => '',
        ];
        return $this->render('index', $data);
    }

    public function actionPage($entity, $mode)
    {
        
        $data = [
            'entity' => $entity,
            'mode' => $mode,
        ];

        switch ($entity . '-' . $mode)
        {
            case 'article-view':
                $data['article'] = require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/article.php');
                $data['paragraphs'] = require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/paragraphs.php');
                break;

            case 'article-comments':
                $data['article'] = require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/article.php');
                $data['paragraphs'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/paragraphs.php'), 2, 4);
                $data['recommendedComments'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 0, 4);
                $data['commentsPage1'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 0, 10);
                $data['commentsPage2'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 10, 10);
                break;

        }

        $model = new Comment();

        $model->user_id = Yii::$app->user->identity->id;
        $model->article_id = 75;
        $model->status = 'published';
        $model->date_created=date('Y-m-d');

        var_dump($_POST);
        var_dump($model->load($_POST));//true
        var_dump($model->save());//false

//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load($_POST) && $model->save()){
//            return $this->redirect([$entity.'-'.$mode, 'id' => $model->id]); // TODO goto to the article
            return $this->render($entity.'-'.$mode, $data);
        }

        return $this->render($entity.'-'.$mode, $data);
    }
}
