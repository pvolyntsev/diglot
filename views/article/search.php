<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\SearchForm */
/* @var $articles */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Search Articles';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
<div class="articles list search">
    <div class="form__container">
        <form class="form-inline form__search">
            <input type="text" class="form-control form__input" placeholder="Search articles here..." name="query">
            <button type="submit" class="form__button btn btn-default fa fa-search"></button>
        </form>
        <div class="search__description">
            <?php
                if (!is_null($searchResult))
                {
                    ?>
                    You found <strong><?= count($articlesFound)?></strong> articles about <strong><?=$query?></strong>. All from our global community of authors and creatives.
                    <?php
                }else
                {
                    echo 'Empty search query.';
                }
                ?>

        </div>
    </div>
</div>
    <?php
    if (!is_null($searchResult))
    {
        $searchResult->prepare();
        $pageNumber = $searchResult->getPagination()->getPage()+1;
        echo ListView::widget([
            'dataProvider' => $searchResult,
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

            'emptyText' => 'No articles to show',
            'emptyTextOptions' => [
                'tag' => 'p'
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
        ]);
    }
    ?>
</div>