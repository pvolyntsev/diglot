<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use app\widgets\ParagraphWidget;

use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $comment app\models\Comment*/
/* @var $model Article */
/* @var $comments_selected ActiveDataProvider */
/* @var $comments ActiveDataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$paragraphMode = ParagraphWidget::MODE_FULL;
$articleLink = null; //['article/view', 'id' => $model->id];
?>

<div class="container article-view">

    <div class="row article-heading">
        <div class="col col-md-6 article-heading-title-translate">
            <h1><?php echo $model->title_translate ?>
                <span class="label"><?php echo $model->langTranslate->language ?></span>
            </h1>
            <a class="permalink" href="<?php echo $model->url_translate ?>"><?php echo $model->url_translate ?></a>
            <p class="author">Перевод <a href="<?php echo $model->translator_url ?>"><?php echo $model->translator_name ?></a></p>
        </div>
        <div class="col col-md-6 article-heading-title-original">
            <h1><?php echo $model->title_original ?>
                <span class="label"><?php echo $model->langOriginal->language ?></span>
            </h1>
            <a class="permalink" href="<?php echo $model->url_original ?>"><?php echo $model->url_original ?></a>
            <p class="author">By <a href="<?php echo $model->author_url ?>"><?php echo $model->author_name ?></a></p>
        </div>
    </div>
    <div class="vertical spacer"></div>
	
	<div class="article-draft">
		<? if ($model->status === draft) {echo 'Draft';}?>
	</div>
	
    <?php foreach($model->paragraphs as $paragraph) { ?>
        <div class="row article-paragraph">
            <?php echo ParagraphWidget::widget(['paragraph' => $paragraph, 'mode' => $paragraphMode, 'link' => $articleLink]) ?>
        </div>
    <?php } ?>

    <div class="row article-footnote">
        <div class="col col-md-1"></div>
        <div class="col col-md-10">
            <p>
                Тексты были взяты из открытых источников и соединены в формате "билингва" (bilingual book).
                Материал на левой стороне страницы является переводом, а на правой - оригиналом.
                Для каждой страницы указан источник, автор и переводчик.
                Если вы заметили неточность перевода, или неправильно сопоставленные абзацы, или текст оформлен неаккуратно - сообщите в комментариях.
            </p>
        </div>
    </div>
</div>

<div class="comments">
    <div class="container">
        <h4>Responses</h4>

        <div class="comment-form">
            <?php if (!Yii::$app->user->isGuest) { ?>
                <?= $this->render('_AddingCommentForm', [
                    'comment' => $comment,
                    'article' => $model,
                ]) ?>
            <?php } else {
                echo "Для добавления комментариев необходимо ". Html::a("авторизоваться",['/login']);
            } ?>
        </div>

        <div id="js-comments-recommended">
            <?php Pjax::begin(['id'=>'comments_selected_list']); ?>
            <?= ListView::widget([
                'dataProvider' => $comments_selected,
                'itemView' => '_comment',
                'layout' => "{items}",
                'emptyText' => '',
                'emptyTextOptions' => [
                    //'tag' => 'p'
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="comments" id="js-comments-page" style="display: none;">
            <?php Pjax::begin(['id'=>'comments_list']); ?>
            <?= ListView::widget([
                'id' =>'xxx',
                'dataProvider' => $comments,
                'itemView' => '_comment',
                'layout' => "{summary}\n{items}\n{pager}",
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>

        <?php if ($comments_selected->totalCount > 0) { ?>
            <div class="comments-show-all" id="js-comments-show-all"><a href="?responses">Show all responses</a></div>
        <?php } ?>

    </div> <!-- /.container -->
</div> <!-- /.comments -->



