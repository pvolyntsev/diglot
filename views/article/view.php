<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\ListView;

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

<div class="container comments">

<div class="comment-form">

    <?php $form = ActiveForm::begin(['id' => 'forum_post', 'method' => 'post',]); ?>

    <!--        --><?//= $form->field($model, 'user_id')->textInput() ?>

    <!--            --><?//= $form->field($model, 'article_id')->hiddenInput() ?>

    <?= $form->field($comment, 'comment')->textarea(['rows' => 6]) ?>

    <!--        --><?//= $form->field($model, 'date_created')->textInput() ?>

    <!--        --><?//= form->field($model, 'date_modified')->textInput() ?>

    <!--        --><?//= $form->field($model, 'status')->dropDownList([ 'published' => 'Published', 'blocked' => 'Blocked', ], ['prompt' => '']) ?>

    <div class="form-group">
<!--        --><?//= Html::submitButton($comment->isNewRecord ? 'Create' : 'Update', ['class' => $comment->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="container comments">
<?= ListView::widget([
    'dataProvider' => $comments,
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_comment', [
            'comment' => $model,
        ]);
    },
]);
?>
<!--    </div>-->
<!---->
<?php
//if (!empty($comments)) { ?>
<!--    <div class="comments-show-all" id="js-comments-show-all"><a href="#">Show all responses</a></div>-->
<?php //}
//?>
<!--    </div-->


