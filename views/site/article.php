<?php
/**
 * Шаблон для app\controllers\actions\ArticleViewAction
 */

use yii\helpers\Html;
use app\models\Article;

/* @see app\controllers\actions\ArticleViewAction */
/* @var $this yii\web\View */
/* @var $error bool */
/* @var $message string */
/* @var $sample array */
/* @var $article Article */
?>

<div class="container article-view">

<?php if (!empty($error)) { ?>
    <h2><?php echo $title ?></h2>
    <br/>

    <p><?php echo $message ?></p>

    <p><?php echo $sample['file'] ?></p>
    <pre>&lt;?php
return <?php var_export($sample['code']) ?>;</pre>

<?php } else { ?>

    <div class="row article-heading">
        <div class="col col-md-6 article-heading-title-translate">
            <h1>
                <p><?=Html::a(Html::encode($article->title_translate), ['view', 'id' => $article->id])?></p>
                <span class="label"><?php echo $article->langTranslate->language ?></span>
            </h1>
        </div>
        <div class="col col-md-6 article-heading-title-original">
            <h1>
                <p><?=Html::a(Html::encode($article->title_original), ['view', 'id' => $article->id])?></p>
                <span class="label"><?php echo $article->langOriginal->language ?></span>
            </h1>
        </div>
    </div>

    <?php foreach($article->paragraphs as $paragraph) {?>
        <div class="row article-paragraph">
            <div class="col col-md-6 article-paragraph-translate">
                <p><?=Html::a(Html::encode($paragraph->paragraph_translate), ['view', 'id' => $article->id])?></p>
            </div>
            <div class="col col-md-6 article-paragraph-original">
                <p><?=Html::a(Html::encode($paragraph->paragraph_original), ['view', 'id' => $article->id])?></p>
            </div>
        </div>
    <?php } ?>

<?php } ?>

</div> <!-- /.container">