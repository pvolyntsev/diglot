<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;

/* @var $this \yii\web\View */
/* @var $article app\models\Article */
/* @var $comment app\models\Comment */
/* @var $added bool */

Pjax::begin(['id'=>'new_comment_form',
    'enablePushState' => false,
    'enableReplaceState' => false
]);

$form = ActiveForm::begin([
    'action' => [ 'add-comment', 'id' => $article->id ],
    'id' => 'addComment',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'options' => [
        'data-pjax' => true,
    ]]);
?>
    <?= $form->field($comment, 'comment')->textarea(['rows' => 6])?>
    <div class="controls form-group">
        <?php echo Html::submitButton($comment->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Create'), ['class' => $comment->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'btn_create','value' => 'add-comment?id='.$article->id]); ?>
        <?php

        if (!empty($added)) {
            $id = 'js-alert-'.time();
            echo Alert::widget([
                'id' => $id,
                'options' => [
                    'class' => 'alert-info float right',
                ],
                'closeButton' => false,
                'body' => Yii::t('app', 'Response added. Thank you!'),
            ]);

            $this->registerJs(<<<JS
jQuery(function(){
    setTimeout(function(){
        jQuery('#$id').fadeOut('slow').remove();
    }, 1500);
});
JS
            );
        }
        ?>
    </div>
<?php
ActiveForm::end();
Pjax::end();
