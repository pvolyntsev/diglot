<?php
use yii\widgets\ListView;
use app\widgets\ParagraphWidget;
use app\models\Article;
use yii\helpers\Html;
use app\widgets\DilingvoWidget;

/**
 * @var Article $model
 * @var $key
 * @var $index
 * @var ListView $widget
 * @var int $page
 */

$paragraphs = (1 == $page) ? array_slice($model->paragraphs, 0, 2) : array_slice($model->paragraphs, 0, 1);
$paragraphMode = 1 == $page ? ParagraphWidget::MODE_FULL : ParagraphWidget::MODE_COMPACT;
$articleLink = ['article/view', 'id' => $model->id];
?>
    <div class="row article-heading">
        <?php $widget = DilingvoWidget::begin(); ?>
        <?php $widget->beginTranslation(); ?>
        <div class="col col-md-6 article-heading-title-translate">
            <h1>
                <?php if (1 == $page) { ?>
                    <p><?=Html::a(Html::encode($model->title_translate), ['view', 'id' => $model->id])?></p>
                <?php } else { ?>
                    <p title="<?php echo Html::encode($model->title_translate) ?>"><?=Html::a(Html::encode(mb_substr($model->title_translate, 0, 40, 'utf-8')).'...', ['view', 'id' => $model->id])?></p>
                <?php } ?>
                <span class="label"><?php echo $model->langTranslate->language ?></span>
            </h1>
            <p class="author">Перевод <?php echo $model->translator_name ?></p>
        </div>
        <?php $widget->endTranslation(); ?>

        <?php $widget->beginOriginal(); ?>
        <div class="col col-md-6 article-heading-title-original">
            <h1>
                <?php if (1 == $page) { ?>
                    <p><?=Html::a(Html::encode($model->title_original), ['view', 'id' => $model->id])?></p>
                <?php } else { ?>
                    <p title="<?php echo Html::encode($model->title_original) ?>"><?=Html::a(Html::encode(mb_substr($model->title_original, 0, 40, 'utf-8')).'...', ['view', 'id' => $model->id])?></p>
                <?php } ?>
                <span class="label"><?php echo $model->langOriginal->language ?></span>
            </h1>
            <p class="author">By <?php echo $model->author_name ?></p>
        </div>
        <?php $widget->endOriginal(); ?>
        <?php DilingvoWidget::end(); ?>
    </div>

    <?php foreach($paragraphs as $paragraph) {?>
        <div class="row article-paragraph">
            <?php echo ParagraphWidget::widget(['paragraph' => $paragraph, 'mode' => $paragraphMode, 'link' => $articleLink]) ?>
        </div>
    <?php } ?>

    <div class="article-more">
        <?=Html::a(Html::encode('. . .'), ['view', 'id' => $model->id])?>
    </div>