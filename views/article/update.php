<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $paragraphs app\models\Paragraph[] */
/* @var $publishFailed bool */

$this->title = 'Update Article: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <?php if ($publishFailed) { ?>
        <div class="has-error">
            <div class="help-block">
                <?php echo \yii\helpers\Html::errorSummary($model, [
                    'header' => '<p>' . Yii::t('app', 'Article can\'t be published') . ':<p>'
                ]) ?>
            </div>
        </div>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
        'paragraphs' => $paragraphs,
    ]) ?>

</div>
