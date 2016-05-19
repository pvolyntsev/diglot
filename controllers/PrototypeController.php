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
                break;

            case 'article-comments':
                $data['article'] = require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/article.php');
                    $data['article']->paragraphs = array_slice($data['article']->paragraphs, 2, 4); // чтобы страница была не очень длинная
                $data['recommendedComments'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 0, 4);
                $data['commentsPage1'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 0, 10);
                $data['commentsPage2'] = array_slice(require(__DIR__ . '/../assets/fixtures/article/things-everyone-should-do-code-review/comments.php'), 10, 10);
                break;

            case 'articles-list':
                $data['articles'] = require(__DIR__ . '/../assets/fixtures/article/articles.php');
                $mode = isset($_GET['page']) && (int)$_GET['page']>1 ? 'list-2' : 'list-1';
                break;

            case 'articles-search':
                $data['articles'] = require(__DIR__ . '/../assets/fixtures/article/articles.php');
                break;
        }

        return $this->render($entity.'-'.$mode, $data);
    }
}
