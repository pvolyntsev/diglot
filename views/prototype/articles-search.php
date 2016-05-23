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
<div class="articles list search">

    <div class="form__container">
        <form class="form-inline form__search">
            <input type="text" class="form-control form__input" placeholder="Search articles here...">
            <button type="submit" class="form__button btn btn-default fa fa-search"></button>
        </form>
        <div class="search__description">
            You found <strong>21</strong> articles about <strong>test search</strong>. All from our global community of authors and creatives.
        </div>
    </div>

<!--    <nav>-->
<!--        <ul class="pager">-->
<!--            <li class="previous"><a href="/prototype/articles/list?page=1"><span aria-hidden="true">&larr;</span> Newer</a></li>-->
<!--            <li class="next"><a href="/prototype/articles/list?page=2">Older <span aria-hidden="true">&rarr;</span></a></li>-->
<!--        </ul>-->
<!--    </nav>-->

    <div class="row two-columns">

        <?php foreach($articles as $article) { ?>
            <div class="col col-md-6">
                <div class="article">
                    <div class="row article-heading">
                        <div class="col col-md-6 article-heading-title-translate">
                            <h1><a href="#"><?php echo $article->title_translate ?></a>
                                <span class="label"><?php echo $article->langOriginal->language ?></span>
                            </h1>
                            <p class="author">Перевод <?php echo $article->translator_name ?></p>
                        </div>
                        <div class="col col-md-6 article-heading-title-original">
                            <h1><a href="#"><?php echo $article->title_original ?></a>
                                <span class="label"><?php echo $article->langOriginal->language ?></span>
                            </h1>
                            <p class="author">By <?php echo $article->author_name ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div> <!-- .row .two-columns -->

    <nav>
        <ul class="pager">
            <li class="previous"><a href="/prototype/articles/list?page=1"><span aria-hidden="true">&larr;</span> Previous</a></li>
            <li class="next"><a href="/prototype/articles/list?page=2">Next <span aria-hidden="true">&rarr;</span></a></li>
        </ul>
    </nav>

</div>