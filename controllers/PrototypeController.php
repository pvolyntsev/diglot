<?php

namespace app\controllers;

use app\models\Article;
use Yii;
use yii\web\Controller;

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
        switch($entity.'-'.$mode)
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
        return $this->render($entity.'-'.$mode, $data);
    }
}
