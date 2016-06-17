<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Article;
use app\models\Paragraph;

/* @var $this yii\web\View */
/* @var $model Article */
/* @var $paragraphs Paragraph[] */
/* @var $form yii\widgets\ActiveForm */


// получаем всех авторов
$languages = \app\models\Language::find()->all();
$languageItems = \yii\helpers\ArrayHelper::map($languages, 'id','language');

/*
<script src="//cdn.jsdelivr.net/medium-editor/latest/js/medium-editor.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/medium-editor/latest/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
*/
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'title_original')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'lang_original_id')->dropDownList($languageItems) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'title_translate')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'lang_translate_id')->dropDownList($languageItems) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'url_original')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'url_translate')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

<?php /*
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'own_original')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'own_translate')->checkbox() ?>
        </div>
    </div>
*/ ?>
    <?php echo Html::activeHiddenInput($model, 'own_original') ?>
    <?php echo Html::activeHiddenInput($model, 'own_translate') ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'author_url')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'translator_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'translator_url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="vertical spacer"></div>

    <div class="horizontal divider"></div>

    <p class="align right"><small><a href="https://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown</a> enabled</small></p>

    <div class="article-paragraphs">
        <div id="js-paragraphs">
            <!--div class="article-paragraph-add" id="js-article-paragraph-add" title="Add text block below"><a class="btn"><i class="fa fa-2x fa-plus-square"></i></a></div-->
            <?php foreach($paragraphs as $paragraph) { ?>
                <div class="row article-paragraph">
                    <div class="col-md-6">
                        <input type="hidden" name="Article[paragraphs][id]" value="<?php echo $paragraph->id ?>"/>
                        <textarea name="Article[paragraphs][paragraph_original][]" placeholder="Original ..." class="editable"><?php echo $paragraph->paragraph_original ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <textarea name="Article[paragraphs][paragraph_translate][]" placeholder="Перевод ..." class="editable"><?php echo $paragraph->paragraph_translate ?></textarea>
                    </div>
                    <div class="article-paragraph-add js-article-paragraph-add" title="Add text block above"><a class="btn"><i class="fa fa-2x fa-plus-square"></i></a></div>
                    <div class="article-paragraph-remove js-article-paragraph-remove" title="Remove text block"><a class="btn"><i class="fa fa-2x fa-minus-square"></i></a></div>
                </div>
            <?php } ?>
        </div>
        <div class="row article-paragraph" id="js-paragraph-template">
            <div class="col-md-6">
                <input type="hidden" name="Article[paragraphs][id]" value="-1"/>
                <textarea name="Article[paragraphs][paragraph_original][]" placeholder="Original ..." class="editable"></textarea>
            </div>
            <div class="col-md-6">
                <textarea name="Article[paragraphs][paragraph_translate][]" placeholder="Перевод ..." class="editable"></textarea>
            </div>
            <div class="article-paragraph-add js-article-paragraph-add" title="Add text block above"><a class="btn"><i class="fa fa-2x fa-plus-square"></i></a></div>
            <div class="article-paragraph-remove js-article-paragraph-remove" title="Remove text block"><a class="btn"><i class="fa fa-2x fa-minus-square"></i></a></div>
        </div>
    </div>

    <div class="form-group">
        <?php if ($model->status == Article::STATUS_PUBLISHED) { ?>
            <?php echo Html::submitButton(Yii::t('app','Back to drafts'), ['name' => 'store', 'class' => 'btn']) ?>
        <?php } else { ?>
            <?php echo Html::submitButton(Yii::t('app','Store in drafts'), ['name' => 'store', 'class' => 'btn']) ?>
        <?php } ?>
        <?php echo Html::submitButton(Yii::t('app','Publish'), ['name' => 'publish', 'class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
