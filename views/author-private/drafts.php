<?php

use yii\web\View;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Article;
use app\models\User;

/**
 * @var $this View
 * @var $author User
 * @var $articles ActiveDataProvider
 */

$this->title = 'Draft Articles';
?>

<div class="container">
    <?= ListView::widget([
        'dataProvider' => $articles,
        'itemView' => '_article',
        'viewParams' => [
            'page' => 1,
        ],

        /*настройки контейнера списка */
        'options' => [
            'tag' => 'div',
            'class' => 'articles list row two-columns',
            'id' => 'articles-list',
        ],

        /*настройки элемента списка */
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'article col col-md-6',
        ],

        'layout' => "<nav>{pager}</nav>\n{items}\n<nav>{pager}</nav>",

        'emptyText' => 'No draft articles found',
        'emptyTextOptions' => [
            'tag' => 'p',
            'class' => 'no-articles'
        ],

        /* настройки постраничной навигации */
        'pager' => [
            'options' => [ 'class' => 'pager' ],
            'nextPageCssClass' => 'next',
            'nextPageLabel' => 'Older &rarr;',
            'prevPageCssClass' => 'previous',
            'prevPageLabel' => '&larr; Newer',
            'maxButtonCount' => 0,
        ],
    ]) ?>
</div>