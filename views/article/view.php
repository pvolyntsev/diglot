<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_original',
            'url_original:url',
            'title_translate',
            'url_translate:url',
            'status',
            'date_created',
            'date_modified',
            'date_deleted',
            'date_published',
            'user_id',
            'author_name',
            'author_url:url',
            'own_original',
            'translator_name',
            'translator_url:url',
            'own_translate',
            'lang_original_id',
            'lang_transtate_id',
        ],
    ]) ?>

</div>
