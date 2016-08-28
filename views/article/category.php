<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Article;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id int */
/* @var $category Category */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php ?>

<div class="container">
		<?php
            $dataProvider->prepare();
            $pageNumber = $dataProvider->getPagination()->getPage()+1;
        ?>
	<div class="row articles-list-title">
		<?php 
		// counter && category name (multylang) Found N article in category "X" ?>	
		<h1><?php echo Yii::t('app', 'CATEGORY:'); echo Yii::t('app', 'CATEGORY_' . $category->category) ?></h1>
		
		<?php // echo Yii::t('app', 'CATEGORY_' . $category->category) ?>
	</div>
		<?= ListView::widget([
            'dataProvider' => $dataProvider,
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