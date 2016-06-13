<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $paragraphs app\models\Paragraph[] */

$this->title = 'Update Article: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'paragraphs' => $paragraphs,
    ]) ?>

</div>
