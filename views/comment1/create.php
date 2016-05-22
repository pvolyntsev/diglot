<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="comment-form">

        <?php $form = ActiveForm::begin(/* todo ACTION ? */); ?>

<!--        --><?//= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'article_id')->hiddenInput() ?>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

<!--        --><?//= $form->field($model, 'date_created')->textInput() ?>

<!--        --><?//= form->field($model, 'date_modified')->textInput() ?>

<!--        --><?//= $form->field($model, 'status')->dropDownList([ 'published' => 'Published', 'blocked' => 'Blocked', ], ['prompt' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
