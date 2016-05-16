<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_translate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_translate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'draft' => 'Draft', 'published' => 'Published', 'blocked' => 'Blocked', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'date_modified')->textInput() ?>

    <?= $form->field($model, 'date_deleted')->textInput() ?>

    <?= $form->field($model, 'date_published')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'own_original')->textInput() ?>

    <?= $form->field($model, 'translator_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translator_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'own_translate')->textInput() ?>

    <?= $form->field($model, 'lang_original_id')->textInput() ?>

    <?= $form->field($model, 'lang_transtate_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
