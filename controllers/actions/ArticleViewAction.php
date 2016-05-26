<?php
/**
 * Этот Action может показывать в упрощённом виде одну статью из базы
 * Без указания автора
 * Без дат и статусов
 * Без комментариев
 * Без лайков и закладок
 */

namespace app\controllers\actions;

use Yii;
use yii\base\Action;

class ArticleViewAction extends Action
{
    /**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     */
    public $view;

    public function run()
    {
        $articleKey = Yii::$app->requestedRoute . Yii::$app->request->url;
        $articles = Yii::$app->params['static.articles'];

        if (!isset($articles[$articleKey]))
        {
            if (Yii::$app->getRequest()->getIsAjax())
            {
                return "$articleKey: Article Not Defined";
            } else {
                return $this->controller->render($this->view ?: $this->id, [
                    'error' => true,
                    'articleKey' => $articleKey,
                    'title' => 'No conditions for Article::findOne() defined',
                    'message' => 'You should define conditions to find one article using <a href="http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#findOne()-detail">Article::findOne()</a>',
                    'sample' => [
                        'file' => 'params.php',
                        'code' => [
                            'static.articles' => [
                                $articleKey => '/* conditions for Article::findOne() */',
                            ]
                        ]
                    ]
                ]);
            }
        }

        $articleCredentials = $articles[$articleKey];
        $article = \app\models\Article::findOne($articleCredentials);
        if (!$article)
        {
            if (Yii::$app->getRequest()->getIsAjax())
            {
                return "$articleKey: Article Not Found";
            } else {
                return $this->controller->render($this->view ?: $this->id, [
                    'error' => true,
                    'articleKey' => $articleKey,
                    'title' => 'Article not found by conditions',
                    'message' => 'The defined conditions to find one article using <a href="http://www.yiiframework.com/doc-2.0/yii-db-baseactiverecord.html#findOne()-detail">Article::findOne()</a> do not allow to find article',
                    'sample' => [
                        'file' => 'params.php',
                        'code' => [
                            'static.articles' => [
                                $articleKey => $articleCredentials,
                            ]
                        ]
                    ]
                ]);
            }
        }

        return $this->controller->render($this->view ?: $this->id, [
            'article' => $article,
        ]);
    }
}