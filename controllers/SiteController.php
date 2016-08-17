<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\forms\ContactForm;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use \app\models;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

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

    public function actionGithubImport()
    {
        return $this->render('githubImport');
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
            'query' => models\Article::find()->where(
                    'status=:published',
                    [
                        ':published' => models\Article::STATUS_PUBLISHED
                    ]
                ),
            'sort' => [
                'defaultOrder' => [
                    'date_published' => SORT_DESC,
                ]
            ],
        ]);
        $response = Yii::$app->getResponse();
        $response->format = Response::FORMAT_XML;
        $response->formatters[Response::FORMAT_XML] = [
            'class' => '\yii\web\XmlResponseFormatter',
            'contentType' => 'application/rss+xml; charset=utf-8',
        ];

        $response->content = \Zelenin\yii\extensions\Rss\RssView::widget([
            'dataProvider' => $dataProvider,
            'channel' => [
                'title' => \Yii::$app->params['name'],
                'link' => Url::toRoute('/', true),
                'description' => \Yii::$app->params['title']['en'] . "<br/>\n" . \Yii::$app->params['title']['ru'],
                'language' => Yii::$app->language
            ],
            'items' => [
                'title' => function ($model, $widget, $feed) {
                    /** @var models\Article $model */
                    return $model->title_original . ($model->title_translate ? "<br/>\n" . $model->title_translate: '');
                },
                'description' => function ($model, $widget, $feed) {
                    /** @var models\Article $model */
                    $paragraphsHtml = '';
                    foreach($model->paragraphs as $i => $paragraph)
                    {
                        $paragraphsHtml .= \app\widgets\ParagraphWidget::widget([
                            'paragraph' => $paragraph,
                            'outputFormat' => \app\widgets\ParagraphWidget::OUTPUT_FORMAT_RSS,
                        ]);

                        if ($i>2)
                            break;
                    }
                    return $paragraphsHtml; //$model->title_translate;
                },
                'link' => function ($model, $widget, $feed) {
                    /** @var models\Article $model */
                    return Url::toRoute(['article/view', 'id' => $model->id], true); //, 'slug' => $model->slug
                },
                'pubDate' => function ($model, $widget, $feed) {
                    /** @var models\Article $model */
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $model->date_published);
                    return $date->format(DATE_RSS);
                },
            ]
        ]);
    }
}
