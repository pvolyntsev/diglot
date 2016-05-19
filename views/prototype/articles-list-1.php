<?php
/**
 * @var $this yii\web\View
 * @var $entity
 * @var $mode
 *
 * @var \app\models\User user
 * @var \app\models\Article[] $articles
 * @var int $page
 */
?>
<div class="articles list">
    <?php $n =0 ?>
    <?php foreach($articles as $article) { ?>
        <?php $n++ ?>

        <?php if ($n <= 2) { ?>
            <div class="article">
                <div class="row article-heading">
                    <div class="col col-md-6 article-heading-title-translate">
                        <h1><a href="#"><?php echo $article->title_translate ?></a>
                            <span class="label"><?php echo $article->lang_transtate->language ?></span>
                        </h1>
                        <p class="author">Перевод <?php echo $article->translator_name ?></p>
                    </div>
                    <div class="col col-md-6 article-heading-title-original">
                        <h1><a href="#"><?php echo $article->title_original ?></a>
                            <span class="label"><?php echo $article->lang_original->language ?></span>
                        </h1>
                        <p class="author">By <?php echo $article->author_name ?></p>
                    </div>
                </div>
                <?php foreach(array_slice($article->paragraphs, 2, 2) as $paragraph) {?>
                    <div class="row article-paragraph">
                        <div class="col col-md-6 article-paragraph-translate">
                            <p><a href="#"><?php echo $paragraph->paragraph_translate ?></a></p>
                        </div>
                        <div class="col col-md-6 article-paragraph-original">
                            <p><a href="#"><?php echo $paragraph->paragraph_original ?></a></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="article-more">
                    <a href="#">read more</a>
                </div>
            </div>
        <?php } else { ?>

            <?php if ($n == 3) { ?>
                <div class="row two-columns">
            <?php } ?>

            <div class="col col-md-6">
                <div class="article">
                    <div class="row article-heading">
                        <div class="col col-md-6 article-heading-title-translate">
                            <h1><a href="#"><?php echo $article->title_translate ?></a>
                                <span class="label"><?php echo $article->lang_transtate->language ?></span>
                            </h1>
                            <p class="author">Перевод <?php echo $article->translator_name ?></p>
                        </div>
                        <div class="col col-md-6 article-heading-title-original">
                            <h1><a href="#"><?php echo $article->title_original ?></a>
                                <span class="label"><?php echo $article->lang_original->language ?></span>
                            </h1>
                            <p class="author">By <?php echo $article->author_name ?></p>
                        </div>
                    </div>
                    <?php foreach(array_slice($article->paragraphs, 2, 1) as $paragraph) {?>
                        <div class="row article-paragraph">
                            <div class="col col-md-6 article-paragraph-translate">
                                <p><a href="#"><?php echo mb_substr($paragraph->paragraph_translate, 0, 100, 'utf-8'), '...' ?></a></p>
                            </div>
                            <div class="col col-md-6 article-paragraph-original">
                                <p><a href="#"><?php echo mb_substr($paragraph->paragraph_original, 0, 100, 'utf-8'), '...' ?></a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php } ?>

    <?php } ?>

    <?php if ($n > 3) { ?>
        </div> <!-- .row .two-columns -->
    <?php } ?>

    <!--div class="row article-footnote">
        <div class="col col-md-1"></div>
        <div class="col col-md-10">
            <p>
                Тексты были взяты из открытых источников и соединены в формате "билингва" (bilingual book).
                Материал на левой стороне страницы является переводом, а на правой - оригиналом.
                Для каждой страницы указан источник, автор и переводчик.
                Если вы заметили неточность перевода, или неправильно сопоставленные абзацы, или текст оформлен неаккуратно - сообщите в комментариях.
            </p>
        </div>
    </div-->

    <nav>
        <ul class="pager">
            <li class="previous"><a href="/prototype/articles/list?page=1"><span aria-hidden="true">&larr;</span> Newer</a></li>
            <li class="next"><a href="/prototype/articles/list?page=2">Older <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>

</div>