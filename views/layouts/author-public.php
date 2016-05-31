<?php

/* @var $this View */
/* @var $content string */
/* @var $author User */

use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\widgets\UserMenuWidget;
use yii\widgets\Breadcrumbs;
use app\models\User;
use app\assets\AppAsset;

$author = $this->params['author'];

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-icon-180x180.png">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Site Properities -->
    <title><?= HTML::encode(Yii::$app->params['title']['en']) ?></title>
    <meta name="description" content="<?= HTML::encode(Yii::$app->params['description.256']) ?>">
    <meta name="keywords" content="<?= HTML::encode(Yii::$app->params['keywords']) ?>" />

    <!-- Special meta -->
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">
    <meta itemprop="description" content="<?= HTML::encode(Yii::$app->params['description.256']) ?>">
    <meta itemprop="image" content="<?= Yii::$app->params['social.image'] ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" value="summary">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">
    <meta name="twitter:description" content="<?= HTML::encode(Yii::$app->params['description.256']) ?>">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="<?= Yii::$app->params['social.image'] ?>">

    <!-- Open Graph tags (facebook, google) -->
    <meta property="og:title"       content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">
    <meta property="og:image"       content="<?= Yii::$app->params['social.image'] ?>">
    <meta property="og:site_name"   content="<?= HTML::encode(Yii::$app->params['name']) ?>">
    <meta property="og:description" content="<?= HTML::encode(Yii::$app->params['description.256']) ?>">

    <!-- VK tags -->
    <link rel="image_src" href="<?= Yii::$app->params['social.image'] ?>">
    <meta name="title"    content="<?= HTML::encode(Yii::$app->params['title']['en']) ?>">

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap profile">
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
        $items[] = UserMenuWidget::widget();
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

    <div class="row profile-container">
        <div class="col-lg-6 col-lg-push-3 col-md-12">
            <section class="box-typical">
                <div class="profile-card">
<!--
                    <div class="profile-card-photo">
                        <img src="img/photo-220-1.jpg" alt="">
                    </div>
-->
                    <div class="profile-card-name"><?php echo $author->username ?></div>
<!--                    <div class="profile-card-status">Company Founder</div>-->
<!--                    <div class="profile-card-location">Greater Seattle Area</div>-->
<!--                    <button type="button" class="btn btn-rounded">Follow</button>-->
<!--
                    <div class="btn-group">
                        <button type="button" class="btn btn-rounded btn-primary-outline dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Connect
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-home"></i>Quant and Verbal</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-cart"></i>Real Gmat Test</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-speed"></i>Prep Official App</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-users"></i>CATprer Test</a>
                            <a class="dropdown-item" href="#"><i class="font-icon font-icon-comments"></i>Third Party Test</a>
                        </div>
                    </div>
-->
                </div><!--.profile-card-->
<!--
                <div class="profile-statistic tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <b>200</b>
                            Connections
                        </div>
                        <div class="tbl-cell">
                            <b>1.9M</b>
                            Followers
                        </div>
                    </div>
                </div>
-->
<!--
                <ul class="profile-links-list">
                    <li class="nowrap">
                        <i class="font-icon font-icon-earth-bordered"></i>
                        <a href="#">example.com</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-fb-fill"></i>
                        <a href="#">facebook.com/example</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-vk-fill"></i>
                        <a href="#">vk.com/example</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-in-fill"></i>
                        <a href="#">linked.in/example</a>
                    </li>
                    <li class="nowrap">
                        <i class="font-icon font-icon-tw-fill"></i>
                        <a href="#">twitter.com/example</a>
                    </li>
                </ul>
-->
            </section><!--.box-typical-->
        </div>
    </div>

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
