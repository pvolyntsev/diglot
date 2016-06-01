<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AuthorPrivateController extends Controller
{
    public $layout = 'author-private';

    /**
     * Список черновиков автора
     */
    public function actionDrafts()
    {
        return $this->render('drafts', [
            #'articles' => $dataProvider,
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