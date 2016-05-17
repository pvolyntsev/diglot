<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<div class="row article-heading">
		<div class="col col-md-6 article-heading-title-translate">
			<h1>
				<span class="label"><?php echo $article->lang_original->language ?></span>
			</h1>
			<?= ListView::widget([
				'dataProvider' => $dataProvider,
				'itemOptions' => ['class' => 'item'],
				'itemView' => function ($model, $key, $index, $widget) {
					return Html::a(Html::encode($model->title_original), ['view', 'id' => $model->id]);
				},
			]) ?>
		</div>
		<div class="col col-md-6 article-heading-title-original" >
			<h1>
				<span class="label"><?php echo $article->lang_translate->language ?></span>
			</h1>
			<?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemOptions' => ['class' => 'item'],
			'itemView' => function ($model, $key, $index, $widget) {
				return Html::a(Html::encode($model->title_translate), ['view', 'id' => $model->id]);
			},
		]) ?>
		</div>
	</div>
</div>
