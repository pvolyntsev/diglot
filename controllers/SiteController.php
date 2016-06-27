<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\forms\ContactForm;
use yii\helpers\Url;
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

    public function actionSitemap()
    {
        // create sitemap
        $sitemap = new Sitemap(__DIR__ . '/sitemap.xml');

        // add some URLs
//                $sitemap->addItem('http://www.diglot.example.com/article');
//                $sitemap->addItem('http://www.diglot.example.com/article', time());
//                $sitemap->addItem('http://www.diglot.example.com/article', time(), Sitemap::HOURLY);
        $sitemap->addItem('http://www.diglot.example.com/article', time(), Sitemap::DAILY, 0.3);

        // write it
        $sitemap->write();

        // get URLs of sitemaps written
        $sitemapFileUrls = $sitemap->getSitemapUrls('http://www.diglot.example.com/');

        // create sitemap for static files
        $staticSitemap = new Sitemap(__DIR__ . '/sitemap_static.xml');

        // add some URLs
//        $staticSitemap->addItem('http://example.com/about');
//        $staticSitemap->addItem('http://example.com/tos');
        $staticSitemap->addItem('http://www.diglot.example.com/team');
//        $staticSitemap->addItem('http://www.diglot.example.com/sitemap');

        // write it
        $staticSitemap->write();

        // get URLs of sitemaps written
        $staticSitemapUrls = $staticSitemap->getSitemapUrls('http://www.diglot.example.com/');

        // create sitemap index file
        $index = new Index(__DIR__ . '/sitemap_index.xml');

        // add URLs
        foreach ($sitemapFileUrls as $sitemapUrl) {
            $index->addSitemap($sitemapUrl);
        }

        // add more URLs
        foreach ($staticSitemapUrls as $sitemapUrl) {
            $index->addSitemap($sitemapUrl);
        }

        // write it
        $index->write();
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
                    return Url::toRoute(['article/view', 'id' => $model->id], true); //, 'slug' => $model->slug
                },
                'pubDate' => function ($model, $widget) {
                    $date = \DateTime::createFromFormat('Y-m-d H:i:s', $model->date_created);
                    return $date->format(DATE_RSS);
                },
            ]
        ]);
    }
}
