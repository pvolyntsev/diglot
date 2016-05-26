<?php
use app\models\Comment;
use yii\helpers\Html;


/**
 * @var $comment Comment
 */
?>


        <div class="comment-feed">
            <?php if (0) { // скрыть панель ?>
            <div class="comment-recommended">
                <div class="comment-recommender">Recommended by <a href="#">Peter Pan</a></div>
            </div>
            <?php } ?>


            <div class="float-left comment-card">
                <div class="card-avatar"><a class="card-avatar" href="#"><img src="/upload/user/0_440x440.png" class="avatar-image u-xs-size32x32"></a></div>
                <div class="card-summary">
                    <div class="card-extra"><a href="#"><?php echo $comment->user->username ?></a></div>
                    <div class="card-extra"><?php echo \yii\timeago\TimeAgo::widget(['timestamp' => $comment->date_created]); ?></div>
                </div>
            </div>

            <div class="comment-content"><p><?php echo $comment->comment ?></p></div>

            <?php if (0) { // скрыть панель ?>
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
            <?php } ?>
        </div>
