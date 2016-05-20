<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Article;
use app\models\Language;

$article=new Article();
$language=new \app\models\Language();
?>

	<div class="article">
		<div class="row article-heading">
			<div class="col col-md-6 article-heading-title-original">
				<h1>
					<?=Html::a(Html::encode($model->title_original), ['view', 'id' => $model->id])?>
					<span class="label"><?php echo $model->langOriginal->language ?></span>
				</h1>
			</div>
			<div class="col col-md-6 article-heading-title-translate">
				<h1>
					<?=Html::a(Html::encode($model->title_translate), ['view', 'id' => $model->id])?>
					<span class="label"><?php echo $model->langTranstate->language ?></span>
				</h1>
			</div>
		</div>
	</div>
