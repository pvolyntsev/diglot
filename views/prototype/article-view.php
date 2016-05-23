<?php
/**
 * @var $this yii\web\View
 * @var $entity
 * @var $mode
 *
 * @var \app\models\User user
 * @var \app\models\Article $article
 * @var \app\models\Comment[] $comments
 */
?>

<div class="row article-heading">
    <div class="col col-md-6 article-heading-title-translate">
        <h1><?php echo $article->title_translate ?>
            <span class="label"><?php echo $article->langTranslate->language ?></span>
        </h1>
        <a class="permalink" href="<?php echo $article->url_translate ?>"><?php echo $article->url_translate ?></a>
        <p class="author">Перевод <a href="<?php echo $article->translator_url ?>"><?php echo $article->translator_name ?></a></p>
    </div>
    <div class="col col-md-6 article-heading-title-original">
        <h1><?php echo $article->title_original ?>
            <span class="label"><?php echo $article->langOriginal->language ?></span>
        </h1>
        <a class="permalink" href="<?php echo $article->url_original ?>"><?php echo $article->url_original ?></a>
        <p class="author">By <a href="<?php echo $article->author_url ?>"><?php echo $article->author_name ?></a></p>
    </div>
</div>
<div class="vertical spacer"></div>
<?php foreach($article->paragraphs as $paragraph) { ?>
    <div class="row article-paragraph">
        <div class="col col-md-6 article-paragraph-translate">
            <p><?php echo $paragraph->paragraph_translate ?></p>
        </div>
        <div class="col col-md-6 article-paragraph-original">
            <p><?php echo $paragraph->paragraph_original ?></p>
        </div>
    </div>
<?php } ?>

<div class="row article-footnote">
    <div class="col col-md-1"></div>
    <div class="col col-md-10">
        <p>
            Тексты были взяты из открытых источников и соединены в формате "билингва" (bilingual book).
            Материал на левой стороне страницы является переводом, а на правой - оригиналом.
            Для каждой страницы указан источник, автор и переводчик.
            Если вы заметили неточность перевода, или неправильно сопоставленные абзацы, или текст оформлен неаккуратно - сообщите в комментариях.
        </p>
    </div>
</div>
