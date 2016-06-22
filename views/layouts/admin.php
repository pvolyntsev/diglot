<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAppAsset;

AdminAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

    <meta name="title"    content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => Yii::$app->params['name'],
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar navbar-inverse navbar-fixed-top',
    ],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
    ]
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'items' => [
        //['label' => 'Add Article', 'url' => ['/article/create'], ],
    ]
]);

$items = [];
if (Yii::$app->user->isGuest)
{
    $items[] = ['label' => 'Login', 'url' => ['/login'],  ];
    $items[] = ['label' => 'Signup', 'url' => ['/signup'],  ];
} else {
    $items[] = ['label' => 'Profile', 'url' => ['/profile'],  ];
    $items[] = '<li>'
        . Html::beginForm(['/logout'], 'post', ['class' => 'navbar-form'])
        . Html::submitButton(
            'Logout', // (' . Yii::$app->user->identity->username . ')
            ['class' => 'btn btn-link']
        )
        . Html::endForm()
        . '</li>';
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);
NavBar::end();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><?php echo Html::a("Users", ['/user/admin']) ?></li>
                <li><?php echo Html::a("User Roles", ['/user/roles']) ?></li>
                <li><?php echo Html::a("Banners", ['/banner']) ?></li>
                <li><?php echo Html::a("Comments", ['/comment']) ?></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?php echo Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
