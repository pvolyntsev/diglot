<?php
date_default_timezone_set('Europe/Kiev');

function merge_configs($base, $customized)
{
    $baseConfig = require($base);
    if (is_file($customized))
        return yii\helpers\ArrayHelper::merge($baseConfig, require($customized));
    return $baseConfig;
}

$params = merge_configs(__DIR__ . '/params.php', __DIR__ . '/params.local.php');
$db = merge_configs(__DIR__ . '/db.php', __DIR__ . '/db.local.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'en',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'class' => 'app\components\LangRequest',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jAGgbpxexwgV7oInQ6yB0cdmKoYSmY7P',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
			'loginUrl' => ['/login'],
		],
		'authClientCollection' => [
			'class' => 'yii\authclient\Collection',
			'clients' => $params['authClientCollection.clients'],
		],
		'urlManager' => [
            'showScriptName' => false,     // Disable index.php
            'enablePrettyUrl' => true,     // Disable ?r= routes
            'enableStrictParsing' => false, // Only routes being listed in rules
			'rules' => [
				//sitemap
					'/sitemap' => 'site/sitemap',
                // Main page & static pages
                '/' => '/article/index',
                #'/contact' => 'site/contact',
                '/about' => 'site/article',
                '/terms' => 'site/article',
                '/team' => 'site/team',
                '/donate' => 'site/donate',
                '/github-integration' => 'site/article',
                'set' => 'lang/set',

                // Auth & user manager
				'/signup' => '/user/user/signup',
				'/login' => '/user/user/login',
				'/logout' => '/user/user/logout',
				'/requestPasswordReset' => '/user/user/request-password-reset',
				'/resetPassword' => '/user/user/reset-password',
                '/profile' => '/user/user/profile',
                '/profile/photo?' => '/user/user/uploadPhoto',
				'/retryConfirmEmail' => '/user/user/retry-confirm-email',
				'/confirmEmail' => '/user/user/confirm-email',
				'/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
				'/oauth/<authclient:[\w\-]+>' => '/user/auth/index',

                // Admin Panel
                '/user/admin' => '/user/admin/index',
                '/user/admin/<action>' => '/user/admin/<action>',
                '/user/roles' => '/user/rbac/index',
                '/user/roles/<action>' => '/user/rbac/<action>',


                // Public Profile
                '/<username>/profile' => 'author-public/profile',
                '/<username>/articles' => 'author-public/articles',
                '/<username>/responses' => 'author-public/responses',
                '/<username>/followings' => 'author-public/followings',
                '/<username>/followers' => 'author-public/followers',

                // Private Profile
                '/profile/drafts' => 'author-private/drafts',
                '/profile/moderation' => 'author-private/moderation',

                // Prototypes
                [ 'pattern' => 'prototype', 'route' => 'prototype/index' ],
				[ 'pattern' => 'prototype/<entity>/<mode>', 'route' => 'prototype/page' ],

                //article
                '/article' => '/article/index',
                '/article/<action>' => '/article/<action>',
				'/article/add-comment' => '/article/addComment',
				'/article/update-comment' => '/article/updateComment',
				'/article/delete-comment' => '/article/DeleteComment',
                '/article/<action>/<id:\d+>' => '/article/<action>',
                '/search' => '/article/search',

				// control panel (adminka)
				'/cp' => '/admin-panel/index',
				
				//comment
				'/cp/comment' => '/comment/index',
				'/cp/comment/<action>' => '/comment/<action>',
				'/cp/comment/<action>/<id:\d+>' => '/comment/<action>',

                // banners
                '/cp/banner' => '/banner/index',
                '/cp/banner/<action>' => '/banner/<action>',
                '/cp/banner/<action>/<id:\d+>' => '/banner/<action>',
				
				// categories
				// TODO

				['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
			],
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
	    'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => $params['mailer.useFileTransport'], // send all mails to a file instead of other transports
            'transport' => $params['mailer.transport'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => 'inet[/127.0.0.1:9200]'],
                // configure more hosts if you have a cluster
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app'       => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
	'modules' => [
		'user' => [
			'class' => 'budyaga\users\Module',
			'userPhotoUrl' => '/upload/user',
			'userPhotoPath' => dirname(__DIR__) . '/web/upload/user'
		],
        'markdown' => [
            'class' => '\kartik\markdown\Module',
        ],
    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    /*$config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.*.*' ],
    ];*/

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.*.*' ]
    ];
}

return $config;
