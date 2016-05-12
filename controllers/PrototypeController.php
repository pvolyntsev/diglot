<?php

namespace app\controllers;

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
        }
        return $this->render($entity.'-'.$mode, $data);
    }
}
