<?php
use yii\widgets\ListView;
use app\models\Article;
use app\models\Language;
use yii\helpers\Html;

$article=new Article();
$language=new \app\models\Language();

/**
 * @var Article $model
 * @var $key
 * @var $index
 * @var ListView $widget
 */

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
	<nav>
        <ul class="pager">
            <li class="previous"><a href="/prototype/articles/list?page=1"><span aria-hidden="true">&larr;</span> Newer</a></li>
            <li class="next"><a href="/prototype/articles/list?page=2">Older <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>
