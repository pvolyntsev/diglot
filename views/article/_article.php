<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Article;

?>

	<div class="article">
		<div class="row article-heading">
			<div class="col col-md-6 article-heading-title-original">
				<h1>
					<a href="#"><?= $model->title_original ?></a>
					<span class="label">russian</span>
				</h1>	
			</div>
			<div class="col col-md-6 article-heading-title-translate">
				<h1>
					<a href="#"><?= $model->title_translate ?></a>
					<span class="label">english</span>
				</h1>
			</div>
		</div>
	</div>
