<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\forms\ContactForm;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use \app\models;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'article' => [
                'class' => '\app\controllers\actions\ArticleViewAction',
            ],
            'donate' => [
                'class' => '\app\controllers\actions\ArticleViewAction',
                'view' => 'donate',
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTeam()
    {
        return $this->render('team');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionRss()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => \app\models\Article::find()->where('status=:published', [':published'=>\app\models\Article::STATUS_PUBLISHED]),
//            'pagination' => [
//                'pageSize' => 10],
            'sort' => [
                'defaultOrder' => [
                    'date_published' => SORT_DESC,
                ]
            ],
        ]);
        $response = Yii::$app->getResponse();
        $headers = $response->getHeaders();

        $headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        $response->content = \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => 'Diglot',
                'link' => Url::toRoute('/', true),
                'description' => 'Статьи ',
                'language' => Yii::$app->language
//                'title_original' => '111',
//                'title_translate' => '111',
//                'link' => Url::toRoute('/', true),

            ],
            'items' => [
                'title' => function ($model, $widget) {
                    return $model->title_original;
                },
                'description' => function ($model, $widget) {
                    return $model->title_translate;
                    //return StringHelper::truncateWords($model->title_translate, 50);
                },
                'link' => function ($model, $widget) {
                    return Url::toRoute(['article/view', 'id' => $model->id, 'slug' => $model->slug], true); //, 'slug' => $model->slug
                },
                'pubDate' => function ($model, $widget) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $model->date_created);
                    return $date->format(DATE_RSS);
                },
            ]
        ]);
    }
}
