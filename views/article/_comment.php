<?php
use app\models\Comment;
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


/**
 * @var $comment Comment
 */

$comment=$model;
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


            <div class="comment-extra">
                <div class="btn-toolbar">
<!--                    <button class="btn btn-mini">like</button>-->
<!--                    <button class="btn btn-mini">reply</button>-->

                    <div class="btn-group pull-right">
                        <div class="btn-group">
<!--                            <button class="btn btn-mini">edit</button>-->
                            <?php
                            $user_id=$comment->user_id; // идентификатор пользователя, который является автором комментария
                            try
                            {
                                if (!Yii::$app->user->isGuest)
                                {
                                    $current_user=Yii::$app->user->identity->getId();// идентификатор текущего пользователя
                                    if ($user_id==$current_user) {

                                        Pjax::begin(['id'=>'delete_comment_form',
                                            'enablePushState' => false,
                                            'enableReplaceState' => false
                                        ]);

                                        $form = ActiveForm::begin([
                                            'action' => [ 'delete-comment', 'id' => $comment->id,],
                                            'id' => 'deleteComment',
                                            'enableClientValidation' => false,
                                            'enableAjaxValidation' => true,
                                            'options' => [
                                                'data-pjax' => true,
                                            ]]);
                                        ?>
                                        <?php echo Html::submitButton('delete', ['class' => 'btn btn-mini','value' => 'delete-comment?id='.$comment->id]); ?>
                                        <?php

                                        ActiveForm::end();
                                        Pjax::end();
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
