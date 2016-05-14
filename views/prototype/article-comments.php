<?php
/**
 * @var $this yii\web\View
 * @var $entity
 * @var $mode
 *
 * @var \app\models\User user
 * @var \app\models\Article $article
 * @var \app\models\Paragraph[] $paragraphs
 * @var \app\models\Comment[] $recommendedComments
 * @var \app\models\Comment[] $commentsPage1
 * @var \app\models\Comment[] $commentsPage2
 */
?>

<?php include(__DIR__.'/article-view.php') ?>

<div class="container comments">

    <div class="comments-heading">
        <div class="heading-content">
            <?php if (empty($commentsPage1)) { ?>
                <span class="comments-heading-title">No responses</span>
            <?php } else { ?>
                <span class="comments-heading-title">Responses</span>
            <?php } ?>
        </div>
    </div>

    <?php if (!empty($commentsPage1)) { ?>
    <div id="js-comments-page" style="display: none;">
    <?php foreach($commentsPage1 as $comment) { ?>
        <div class="comment-feed">
            <?php if (rand(0,1)) { ?>
            <div class="comment-recommended">
                <div class="comment-recommender">Recommended by <a href="#">Peter Pan</a></div>
            </div>
            <?php } ?>


            <div class="float-left comment-card">
                <div class="card-avatar"><a class="card-avatar" href="#"><img src="/upload/user/<?php echo $comment->user->photo ?>" class="avatar-image u-xs-size32x32"></a></div>
                <div class="card-summary">
                    <span class="card-extra"><a href="#"><?php echo $comment->user->username ?></a></span>
                    <span class="card-extra"><?php echo \yii\timeago\TimeAgo::widget(['timestamp' => $comment->date_created]); ?></span>
                </div>
            </div>

            <div class="comment-content"><p><?php echo $comment->comment ?></p></div>

            <div class="comment-extra">
                <div class="btn-toolbar">
                    <button class="btn btn-mini">like</button>
                    <button class="btn btn-mini">reply</button>

                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button class="btn btn-mini">edit</button>
                            <button class="btn btn-mini">delete</button>
                        </div>
                    </div>

                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button class="btn btn-mini">share</button>
                            <button class="btn btn-mini">report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <?php } ?>

<!--    Вставим поле для добавления нового комментария-->
    <div class="comment-feed">
        <div class="comment-recommended">
            <div class="comment-recommender">Add new comment</a></div>
        </div>

        <div class="comment-content"><p><textarea rows="5" class="addComment" name="newComment"><?=$data?></textarea></p></div>

        <div class="comment-extra">
            <div class="btn-toolbar">
                <button class="btn btn-mini">confirm</button>
            </div>
        </div>
    </div>

    <div id="js-comments-recommended">
    <?php foreach($recommendedComments as $comment) { ?>
        <div class="comment-feed">
            <div class="comment-recommended">
                <div class="comment-recommender">Recommended by <a href="#">Peter Pan</a></div>
            </div>

            <div class="float-left comment-card">
                <div class="card-avatar"><a class="card-avatar" href="#"><img src="/upload/user/<?php echo $comment->user->photo ?>" class="avatar-image u-xs-size32x32"></a></div>
                <div class="card-summary">
                    <span class="card-extra"><a href="#"><?php echo $comment->user->username ?></a></span>
                    <span class="card-extra"><?php echo \yii\timeago\TimeAgo::widget(['timestamp' => $comment->date_created]); ?></span>
                </div>
            </div>

            <div class="comment-content"><p><?php echo $comment->comment ?></p></div>

            <div class="comment-extra">
                <div class="btn-toolbar">
                        <button class="btn btn-mini">like</button>
                        <button class="btn btn-mini">reply</button>

                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button class="btn btn-mini">edit</button>
                            <button class="btn btn-mini">delete</button>
                        </div>
                    </div>

                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button class="btn btn-mini">share</button>
                            <button class="btn btn-mini">report</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>

    <?php if (!empty($commentsPage1)) { ?>
        <div class="comments-show-all" id="js-comments-show-all"><a href="#">Show all responses</a></div>
    <?php } ?>
</div>