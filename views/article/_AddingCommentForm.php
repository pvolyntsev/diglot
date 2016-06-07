<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $comment app\models\Comment */

Pjax::begin(['id'=>'new_note',
    'enablePushState' => false,
    'enableReplaceState' => false
]);
$form = ActiveForm::begin([
    'action' => [ 'add-comment', 'id' => $model->id ],
    'id' => 'addComment',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'options' => [
        'data-pjax' => true,
    ]]);
?>
    <?= $form->field($comment, 'comment')->textarea(['rows' => 6])?>
    <div class="controls form-group">
        <?php echo Html::submitButton($comment->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Create'), ['class' => $comment->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'btn_create','value' => 'add-comment?id='.$model->id]); ?>
    </div>

<?php ActiveForm::end();
Pjax::end();
?>