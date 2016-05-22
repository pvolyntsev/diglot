<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;

//$page = $widget->dataProvider->getPagination()->getPage() + 1;
?>

<div class="article-index">
    <div class="col col-md-2">
		<h1><?= Html::encode($this->title) ?></h1>
		<p>
			<?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
		</p>
	</div>
	<div class="articles list">
		
			<div class="row two-columns">
				<?= ListView::widget([
					'dataProvider' => $dataProvider,
					'itemOptions' => ['class' => 'item'],
					'itemView' => '_article',
					// widget settings
					/*настройки контейнера списка
					'options' => [
						'tag' => 'div',
						'class' => 'news-list',
						'id' => 'news-list',
					],
					*/
					'layout' => "{pager}\n{summary}\n{items}\n{pager}",
					'summary' => 'showing {count} of {totalCount} pages',
					'summaryOptions' => [
						'tag' => 'span',
						'class' => 'my-summary'
					],
				 
					'itemOptions' => [
						'tag' => 'div',
						'class' => 'news-item',
					],
				 
					'emptyText' => '<p>articles do not exist</p>',
					'emptyTextOptions' => [
						'tag' => 'p'
					],
				 
					'pager' => [
						//'firstPageLabel' => 'Первая',
						//'lastPageLabel' => 'Последняя',
						'nextPageLabel' => 'Older &rarr;',
						'prevPageLabel' => '&larr; Newer',        
						'maxButtonCount' => 0,
					],
				]) ?>
			</div>
	</div>
</div>
