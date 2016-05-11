<?php
/**
 * @var $this yii\web\View
 * @var $entity
 * @var $mode
 *
 * @var \app\models\User user
 * @var \app\models\Article $article
 * @var \app\models\Paragraph[] $paragraphs
 * @var \app\models\Comment[] $comments
 */
?>
<style type="text/css">
.article-header h1 {
    margin: 0 0 0.2em 0;
    font-weight: 800;
    font-size: 1.5em;
}
.article-header-original .label {
    background-color: #3a87ad;
    color: #fff;
    font-size: 0.5em;;
}
.article-header-translate .label {
    background-color: #468847;
    color: #fff;
    font-size: 0.5em;;
}
.vertical.spacer {
    padding-top: 3em;
}
.article-paragraph {
    padding: 0.5em 0;
}
.article-footnote {
    color: #999;
    margin-top: 1em;
}
</style>

<div class="row article-header">
    <div class="col col-lg-6 article-header-translate">
        <h1><?php echo $article->title_translate ?>
            <span class="label"><?php echo $article->lang_transtate->language ?></span>
        </h1>
        <a class="permalink" href="<?php echo $article->url_translate ?>"><?php echo $article->url_translate ?></a>
        <p class="author">Перевод <a href="<?php echo $article->translator_url ?>"><?php echo $article->translator_name ?></a></p>
    </div>
    <div class="col col-lg-6 article-header-original">
        <h1><?php echo $article->title_original ?>
            <span class="label"><?php echo $article->lang_original->language ?></span>
        </h1>
        <a class="permalink" href="<?php echo $article->url_original ?>"><?php echo $article->url_original ?></a>
        <p class="author">By <a href="<?php echo $article->author_url ?>"><?php echo $article->author_name ?></a></p>
    </div>
</div>
<div class="vertical spacer"></div>
<?php foreach($paragraphs as $paragraph) {?>
<div class="row article-paragraph">
    <div class="col col-lg-6 article-paragraph-translate">
        <p><?php echo $paragraph->paragraph_translate ?></p>
    </div>
    <div class="col col-lg-6 article-paragraph-original">
        <p><?php echo $paragraph->paragraph_original ?></p>
    </div>
</div>
<?php } ?>

<div class="row article-footnote">
    <div class="col col-lg-1"></div>
    <div class="col col-lg-10">
        <p>
        Тексты были взяты из открытых источников и соединены в формате "билингва" (bilingual book).
        Материал на левой стороне страницы является переводом, а на правой - оригиналом.
        Для каждой страницы указан источник, автор и переводчик.
        Если вы заметили неточность перевода, или неправильно сопоставленные абзацы, или текст оформлен неаккуратно - сообщите в комментариях.
        </p>
    </div>
</div>