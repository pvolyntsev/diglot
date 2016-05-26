<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\SearchForm */
/* @var $articles */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Search Articles';
$this->params['breadcrumbs'][] = $this->title;
//$searchResult->prepare();
$pageNumber = $searchResult->getPagination()->getPage()+1;


?>
<div class="container">
<div class="articles list search">
    <div class="form__container">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'query')->textInput(['autofocus' => true]) ?>
        <?= Html::submitButton('', ['class' => 'form__button btn btn-default fa fa-search', 'name' => 'search-button']) ?>
        <?php ActiveForm::end(); ?>
        <div class="search__description">
            You found <strong><?= count($articlesFound)?></strong> articles about <strong><?=$model->query?></strong>. All from our global community of authors and creatives.
        </div>
    </div>
</div>

<?= ListView::widget([
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
]) ?>
</div>