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
?>

<div class="container">
    <?php
    $articles->prepare();
    $pageNumber = $articles->getPagination()->getPage()+1;
    ?>

    <?= ListView::widget([
        'dataProvider' => $articles,
        'itemView' => '_article',
        'viewParams' => [
            'page' => $pageNumber,
        ],

        /*настройки контейнера списка */
        'options' => [
            'tag' => 'div',
            'class' => 'articles list' . ($pageNumber > 1 ? ' row two-columns' : '') ,
            'id' => 'articles-list',
        ],

        /*настройки элемента списка */
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'article' . ($pageNumber > 1 ? ' col col-md-6' : ''),
        ],

        'layout' => $pageNumber > 1 ? "<nav>{pager}</nav>\n{items}\n<nav>{pager}</nav>" : "{items}\n<nav>{pager}</nav>",

        'emptyText' => 'No articles from ' . $author->username . ' were published',
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