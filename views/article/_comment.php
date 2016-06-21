<?php
use app\models\Comment;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use yii\widgets\Pjax;

/**
 * @var $comment Comment
 *  @var $deleted bool
 */

$comment=$model;
$user=new \budyaga\users\models\User();
$current_user=$user->findOne($comment->user_id)->username;
?>

<div class="comment-feed">

    <div class="comment-recommended">
        <div class="comment-recommender">Commented by <a href="#"><?=$current_user?></a></div>
    </div>

    <div class="float-left comment-card">
        <div class="card-avatar"><a class="card-avatar" href="#"><img src="/upload/user/0_440x440.png" class="avatar-image u-xs-size32x32"></a></div>
        <div class="card-summary">
            <div class="card-extra"><a href="#"><?php echo $comment->user->username ?></a></div>
            <div class="card-extra"><?php echo \yii\timeago\TimeAgo::widget(['timestamp' => $comment->date_created]); ?></div>
        </div>
    </div>

    <div class="comment-content"><p id="comment_<?= $comment->id ?>"><?php echo $comment->comment ?></p></div>

    <div class="comment-extra">
        <div class="btn-toolbar">
            <!--                    <button class="btn btn-mini">like</button>-->
            <!--                    <button class="btn btn-mini">reply</button>-->

            <div class="btn-group pull-right">
                <div class="btn-group">
                    <?php
                    $user_id=$comment->user_id; // идентификатор пользователя, который является автором комментария

                    try
                    {
                        if (!Yii::$app->user->isGuest)
                        {
                            $current_user=Yii::$app->user->identity->getId();// идентификатор текущего пользователя
                            if ($user_id==$current_user) {
                                ?>
                                <button  class="btn btn-mini"  onclick="javascript:delete_comment(<?= $comment->id ?>,<?= $comment->article_id ?>);">delete</button>
                                <button  class="btn btn-mini"  onclick="javascript:update_comment(<?= $comment->id ?>,<?= $comment->article_id ?>);">update</button>
                                <?php
                            }
                        }
                    }
                    catch (\yii\base\ErrorException $ex)
                    {
                        $current_user=null;
                    }
                    ?>
                </div>

            </div>

            <div class="btn-group pull-right">
                <div class="btn-group">
                    <!--                            <button class="btn btn-mini">share</button>-->
                    <!--                            <button class="btn btn-mini">report</button>-->
                </div>
            </div>
        </div>
    </div>

</div>

