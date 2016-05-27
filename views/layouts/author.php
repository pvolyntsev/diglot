<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
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

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

    <meta name="title"    content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['name'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => '<i class="fa fa-2x fa-plus-square"></i> Add Article', 'url' => ['/article/create'], 'encode' => false, 'options' => [ 'class' => 'link link-publish'] , 'icon'=>'dd'],
        ]
    ]);

    $items = [
        '<li>'
            . Html::beginForm(['/search'], 'get', ['class' => 'navbar-form navbar-search-form'])
            . Html::textInput('query','', ['placeholder' => 'Search...', 'class' => 'form-control' ])
            . Html::endForm()
        . '</li>'
    ];

    if (Yii::$app->user->isGuest)
    {
        $items[] = ['label' => '<i class="fa fa-2x fa-sign-in"></i> Login', 'url' => ['/login'], 'encode' => false, 'options' => [ 'class' => 'link']];
        $items[] = ['label' => '<i class="fa fa-2x fa-user-plus"></i> Signup', 'url' => ['/signup'], 'encode' => false, 'options' => [ 'class' => 'link']];
    } else {
        $items[] = ['label' => '<i class="fa fa-2x fa-user"></i> Profile', 'url' => ['/profile'], 'encode' => false, 'options' => [ 'class' => 'link']];
        $items[] = '<li>'
                . Html::beginForm(['/logout'], 'post', ['class' => 'navbar-form navbar-login-form'])
                . Html::submitButton(
                    '<i class="fa fa-2x fa-sign-out"></i> Logout', // (' . Yii::$app->user->identity->username . ')
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

    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['name'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => '<i class="fa fa-2x fa-plus-square"></i> Add Article', 'url' => ['/article/create'], 'encode' => false, 'options' => [ 'class' => 'link link-publish'] , 'icon'=>'dd'],
        ]
    ]);

    $items = [
        '<li>'
        . Html::beginForm(['/search'], 'get', ['class' => 'navbar-form navbar-search-form'])
        . Html::textInput('query','', ['placeholder' => 'Search...', 'class' => 'form-control' ])
        . Html::endForm()
        . '</li>'
    ];

    if (Yii::$app->user->isGuest)
    {
        $items[] = ['label' => '<i class="fa fa-2x fa-sign-in"></i> Login', 'url' => ['/login'], 'encode' => false, 'options' => [ 'class' => 'link']];
        $items[] = ['label' => '<i class="fa fa-2x fa-user-plus"></i> Signup', 'url' => ['/signup'], 'encode' => false, 'options' => [ 'class' => 'link']];
    } else {
        $items[] = '<li><div class="dropdown navbar-dropdown-profile">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <i class="fa fa-2x fa-user"></i> Profile
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li>' . Html::a('<i class="fa fa-2x fa-cogs"></i> Settings', ['/author/settings'] ) . '</li>
    <li role="separator" class="divider"></li>
    <li>' . Html::a('<i class="fa fa-2x fa-file-text"></i> Articles', ['/author/articles-published'] ) . '</li>
    <li>' . Html::a('<i class="fa fa-2x fa-file"></i> Draft', ['/author/articles-drafts'] ) . '</li>
    <li role="separator" class="divider"></li>
    <li>' . Html::a('<i class="fa fa-2x fa-plus-square"></i> Add Article', ['/article/create'] ) . '</li>
  </ul>
</div></li>';
        $items[] = '<li>'
            . Html::beginForm(['/logout'], 'post', ['class' => 'navbar-form navbar-login-form'])
            . Html::submitButton(
                '<i class="fa fa-2x fa-sign-out"></i> Logout', // (' . Yii::$app->user->identity->username . ')
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

    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <ul>
                    <li class="brand-name"><i class="fa fa-copyright"></i> <?php echo Yii::$app->params['name'] ?> <?= date('Y') ?></li>
                    <li>&nbsp; <?= HTML::a('<i class="fa fa-plus-square"></i> Publish new Article or Translation', [ '/article/create' ]) ?></li>
                    <li>&nbsp; <?= HTML::a('<i class="fa fa-file-text"></i> Terms', [ '/terms' ]) ?></li>
                    <li>&nbsp; <?= HTML::a('<i class="fa fa-github"></i> GitHub Integration', [ '/github-integration' ]) ?></li>
                </ul>
            </div>
            <div class="col col-md-4">
                <ul>
                    <li>&nbsp;</li>
                    <li><?= HTML::a('<i class="fa fa-info-circle"></i> About Diglot Service', [ '/about' ]) ?></li>
                    <li><?= HTML::a('<i class="fa fa-group"></i> Team Behind Service', [ '/team' ]) ?></li>
                    <li><?= HTML::a('<i class="fa fa-money"></i> Donate', [ '/donate' ]) ?></li>
                </ul>
            </div>
            <div class="col col-md-4">
                <ul>
                    <li>&nbsp;</li>
                    <li>Credits:</li>
                    <li>&nbsp; <a href="https://icons8.com/line-awesome">Line Awesome</a> font by <a href="https://icons8.com/">Icons8</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
