<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Article;
use app\models\Paragraph;
use app\models\Category;
use app\models\CategoryOfArticle;

/* @var $this yii\web\View */
/* @var $model Article */
/* @var $paragraphs Paragraph[] */
/* @var $categories Category[] */
/* @var $form yii\widgets\ActiveForm */


// получаем всех авторов
$languages = \app\models\Language::find()->all();
$languageItems = \yii\helpers\ArrayHelper::map($languages, 'id','language');

// получаем все категории
$categoriesRef = \app\models\Category::find()->all();
$categoriesReference = [];
foreach($categoriesRef as $category)
    $categoriesReference[$category->id] = Yii::t('app', 'CATEGORY_'.$category->category);
asort($categoriesReference);
$categoriesReference = ['' => '(' . Yii::t('app', 'CHOOSE_CATEGORY') .')'] + $categoriesReference;

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

    <div class="row">
        <div class="col-md-12">
            <label class="control-label" for="article-category-0"><?php echo Yii::t('app', 'CATEGORY') ?></label><br/>
            <?php
				
				$categoryId = Yii::$app->db
						->createCommand("SELECT `category_id` FROM `category_of_article` WHERE `article_id`=:art_id", ['art_id' => $model->id])
						->queryAll();
				
				$id[0] = isset($categories[0])? $categories[0]->id : $categoryId[0];
                $id[1] = isset($categories[1])? $categories[1]->id : $categoryId[1];
                $id[2] = isset($categories[2])? $categories[2]->id : $categoryId[2];
            ?>
			<?php echo Html::dropDownList('Article[category][]', $id[0], $categoriesReference, ['id' => 'article-category-0'])?>
            <?php echo Html::dropDownList('Article[category][]', $id[1], $categoriesReference, ['id' => 'article-category-1'])?>
            <?php echo Html::dropDownList('Article[category][]', $id[2], $categoriesReference, ['id' => 'article-category-2'])?>
        </div>
    </div>

    <div class="vertical spacer"></div>

    <div class="horizontal divider"></div>
    <?php if ($model->hasErrors('paragraphs')) { ?>
        <div class="has-error">
            <div class="help-block">
                <?php echo \yii\helpers\Html::error($model, 'paragraphs') ?>
            </div>
        </div>
    <?php } ?>

    <p class="align right"><small><a href="https://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown</a> enabled</small></p>

    <div class="article-paragraphs">
        <div class="article-paragraphs-active" id="js-paragraphs">
            <div class="article-paragraph-add js-article-paragraph-add" title="Add text block above"><a class="btn"><i class="fa fa-plus-square"></i></a></div>
            <?php foreach($paragraphs as $paragraph) { ?>
                <div class="row article-paragraph">
                    <div class="col-md-6">
                        <input type="hidden" name="Article[paragraphs][id]" value="<?php echo $paragraph->id ?>"/>
                        <div class="expandingArea">
                            <pre><span></span><br></pre>
                            <textarea name="Article[paragraphs][paragraph_original][]" placeholder="Original ..." class="editable"><?php echo $paragraph->paragraph_original ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="expandingArea">
                            <pre><span></span><br></pre>
                            <textarea name="Article[paragraphs][paragraph_translate][]" placeholder="Перевод ..." class="editable"><?php echo $paragraph->paragraph_translate ?></textarea>
                        </div>
                    </div>
                    <div class="article-paragraph-add js-article-paragraph-add" title="Insert text block below"><a class="btn"><i class="fa fa-plus-square"></i></a></div>
                    <div class="article-paragraph-remove js-article-paragraph-remove" title="Remove text block"><a class="btn"><i class="fa fa-minus-square"></i></a></div>
                </div>
            <?php } ?>
        </div>
        <div class="row article-paragraph article-paragraph-new" id="js-paragraph-template">
            <div class="col-md-6">
                <input type="hidden" name="Article[paragraphs][id]" value="-1"/>
                <div class="expandingArea">
                    <pre><span></span><br></pre>
                    <textarea name="Article[paragraphs][paragraph_original][]" placeholder="Original ..." class="editable"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="expandingArea">
                    <pre><span></span><br></pre>
                    <textarea name="Article[paragraphs][paragraph_translate][]" placeholder="Перевод ..." class="editable"></textarea>
                </div>
            </div>
            <div class="article-paragraph-add js-article-paragraph-add" title="Add text block below"><a class="btn"><i class="fa fa-plus-square"></i></a></div>
            <div class="article-paragraph-remove js-article-paragraph-remove" title="Remove text block"><a class="btn"><i class="fa fa-minus-square"></i></a></div>
        </div>
    </div>

    <div class="form-group">
        <?php if ($model->isNewRecord) { ?>
            <?php echo Html::submitButton(Yii::t('app','Save'), ['name' => 'store', 'class' => 'btn btn-primary']) ?>
        <?php } else { ?>
            <?php if (Article::STATUS_PUBLISHED == $model->status) { ?>
                <?php echo Html::submitButton(Yii::t('app','Back to drafts'), ['name' => 'store', 'class' => 'btn']) ?>
            <?php } elseif (Article::STATUS_DRAFT == $model->status) { ?>
                <?php echo Html::submitButton(Yii::t('app','Keep in drafts'), ['name' => 'store', 'class' => 'btn']) ?>
            <?php } else { ?>
                <?php echo Html::submitButton(Yii::t('app','Store in drafts'), ['name' => 'store', 'class' => 'btn']) ?>
            <?php } ?>
            <?php echo Html::submitButton(Yii::t('app','Publish'), ['name' => 'publish', 'class' => 'btn btn-primary']) ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
