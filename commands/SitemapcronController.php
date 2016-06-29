<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Url;
use \app\models;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

class SitemapcronController extends Controller
{
    public function actionSitemap()
    {
        // create sitemap
        $sitemap = new Sitemap('web/sitemap.xml');

        // add some URLs
//                $sitemap->addItem('http://www.diglot.example.com/article');
//                $sitemap->addItem('http://www.diglot.example.com/article', time());
//                $sitemap->addItem('http://www.diglot.example.com/article', time(), Sitemap::HOURLY);
        $sitemap->addItem('http://l.diglot.copist.ru/article', time(), Sitemap::DAILY, 0.3);

        // write it
        $sitemap->write();

        // get URLs of sitemaps written
        $sitemapFileUrls = $sitemap->getSitemapUrls('http://l.diglot.copist.ru/');

        // create sitemap for static files
        $staticSitemap = new Sitemap('web/sitemap_static.xml');

        // add some URLs
        $staticSitemap->addItem('http://l.diglot.copist.ru/team');

        // write it
        $staticSitemap->write();

        // get URLs of sitemaps written
        $staticSitemapUrls = $staticSitemap->getSitemapUrls('http://l.diglot.copist.ru/');

        // create sitemap index file
        $index = new Index('web/sitemap_index.xml');

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
