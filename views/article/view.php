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
$page = Yii::$app->request->get('page');
?>

<div class="container article-view">

    <div class="row article-heading">
        <div class="col col-md-6 article-heading-title-translate">
            <h1><?php echo $model->title_translate ?>
                <span class="label"><?php echo $model->langTranslate->language ?></span>
            </h1>
            <?php if ($model->url_translate) { ?>
                <a class="permalink" href="<?php echo $model->url_translate ?>"><?php echo $model->url_translate ?></a>
            <?php } ?>
            <?php if ($model->translator_url && $model->translator_name) { ?>
                <p class="author">Перевод <a href="<?php echo $model->translator_url ?>"><?php echo $model->translator_name ?></a></p>
            <?php } elseif ($model->translator_name) { ?>
                <p class="author">Перевод <?php echo $model->translator_name ?></p>
            <?php } ?>
        </div>
        <div class="col col-md-6 article-heading-title-original">
            <h1><?php echo $model->title_original ?>
                <span class="label"><?php echo $model->langOriginal->language ?></span>
            </h1>
            <?php if ($model->url_original) { ?>
                <a class="permalink" href="<?php echo $model->url_original ?>"><?php echo $model->url_original ?></a>
            <?php } ?>
            <?php if ($model->author_url && $model->translator_name) { ?>
                <p class="author">By <a href="<?php echo $model->author_url ?>"><?php echo $model->author_name ?></a></p>
            <?php } elseif ($model->author_name) { ?>
                <p class="author">Перевод <?php echo $model->author_name ?></p>
            <?php } ?>
        </div>
    </div>
    <div class="vertical spacer"></div>
	
	<?php if (Article::STATUS_DRAFT == $model->status) {
		echo '<div class="article-draft">Draft</div>';
		}
	?>	
	
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
        <a name="responses"></a>
        <h4>Responses</h4>

        <div class="comment-form">
            <?php

            if (!Yii::$app->user->isGuest) {
                echo $this->render('_AddingCommentForm', [
                    'comment' => $comment,
                    'article' => $model,
                ]);
            } else {
                echo "Для добавления комментариев необходимо ". Html::a("авторизоваться",['/login']);
            }
            ?>
        </div>

        <?php if (is_null($page)) { ?>
            <div class="comments" id="js-comments-recommended">
                <?php
                Pjax::begin(['id'=>'comments_selected_list']);
                echo ListView::widget([
                    'dataProvider' => $comments_selected,
                    'itemView' => '_comment',
                    'layout' => "{items}",
                    'emptyText' => '',
                    'emptyTextOptions' => [
                        //'tag' => 'p'
                    ],
                ]);
                Pjax::end();
                ?>
            </div>

            <?php if ($comments_selected->totalCount > 0) { ?>
                <div class="comments-show-all" id="js-comments-show-all"><?php echo Html::a(Yii::t('app', 'Show all responses'), ['view', 'id' => $model->id, 'page' => 1, '#' => 'responses']) ?></div>
            <?php } ?>
        <?php } ?>

        <div class="comments" id="js-comments-page" <?php if (is_null($page)) echo 'style="display: none;"'; ?>>
            <?php
            Pjax::begin(['id'=>'comments_list']);
            echo ListView::widget([
                'dataProvider' => $comments,
                'itemView' => '_comment',
                'layout' => "{summary}\n{items}\n{pager}",
            ]);
            Pjax::end();
            ?>
        </div>

    </div> <!-- /.container -->
</div> <!-- /.comments -->



