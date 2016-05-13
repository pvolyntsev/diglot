<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
           # ['label' => 'Home', 'url' => ['/site/index']],
        ],
    ]);
    NavBar::end();
    ?>

    <div style="height: 60px;"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col col-lg-2">
                <!--Sidebar content-->
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo Url::to(['prototype/page', 'entity' => 'article', 'mode' => 'view']);?>">Article/View</a>
                    <a class="list-group-item" href="<?php echo Url::to(['prototype/page', 'entity' => 'article', 'mode' => 'edit']);?>">Article/Edit</a>
                    <a class="list-group-item" href="<?php echo Url::to(['prototype/page', 'entity' => 'article', 'mode' => 'comments']);?>">Article/Comments</a>
                </div>
            </div>
            <div class="col col-lg-8">
                <!--Body content-->
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
            <div class="span2"></div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
