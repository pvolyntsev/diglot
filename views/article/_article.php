<?php
use yii\widgets\ListView;
use app\models\Article;
use app\models\Language;
use yii\helpers\Html;

/**
 * @var Article $model
 * @var $key
 * @var $index
 * @var ListView $widget
 */

$page = $widget->dataProvider->getPagination()->getPage() + 1;
?>
<?php if (1== $page) { ?>

	<div class="article">
		<div class="row article-heading">
			<div class="col col-md-6 article-heading-title-translate">
				<h1><a href="#"><?php echo $model->title_translate ?></a>
					<span class="label"><?php echo $model->langTranslate->language ?></span>
				</h1>
				<p class="author">Перевод <?php echo $model->translator_name ?></p>
			</div>
			<div class="col col-md-6 article-heading-title-original">
				<h1><a href="#"><?php echo $model->title_original ?></a>
					<span class="label"><?php echo $model->langOriginal->language ?></span>
				</h1>
				<p class="author">By <?php echo $model->author_name ?></p>
			</div>
		</div>
	</div>

<?php } else { ?>
	<div class="article">
		<div class="row article-heading">
			<div class="col col-md-5 article-heading-title-original">
				<h1>
					<?=Html::a(Html::encode($model->title_original), ['view', 'id' => $model->id])?>
					<span class="label"><?php echo $model->langOriginal->language ?></span>
				</h1>
			</div>
			<div class="col col-md-5 article-heading-title-translate">
				<h1>
					<?=Html::a(Html::encode($model->title_translate), ['view', 'id' => $model->id])?>
					<span class="label"><?php echo $model->langTranslate->language ?></span>
				</h1>
			</div>
		</div>
	</div>
<?php } ?>
<!--
<nav>
	<ul class="pager">
		<li class="previous"><a href="/prototype/articles/list?page=1"><span aria-hidden="true">&larr;</span> Newer</a></li>
		<li class="next"><a href="/prototype/articles/list?page=2">Older <span aria-hidden="true">&rarr;</span></a></li>
	</ul>
</nav>
-->

	
