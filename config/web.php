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
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
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
            'enableStrictParsing' => true, // Only routes being listed in rules
			'rules' => [
                // Main page & static pages
                '/' => 'site/index',
                '/contact' => 'site/contact',
                '/about' => 'site/about',
				
                // Auth & user manager
				'/signup' => '/user/user/signup',
				'/login' => '/user/user/login',
				'/logout' => '/user/user/logout',
				'/requestPasswordReset' => '/user/user/request-password-reset',
				'/resetPassword' => '/user/user/reset-password',
				'/profile' => '/user/user/profile',
				'/retryConfirmEmail' => '/user/user/retry-confirm-email',
				'/confirmEmail' => '/user/user/confirm-email',
				'/unbind/<id:[\w\-]+>' => '/user/auth/unbind',
				'/oauth/<authclient:[\w\-]+>' => '/user/auth/index',

                // Prototypes
                [ 'pattern' => 'prototype', 'route' => 'prototype/index' ],
				[ 'pattern' => 'prototype/<entity>/<mode>', 'route' => 'prototype/page' ],

				//article
				'/article' => '/article/index',
				'/article/view' => '/article/view',
				'/article/create' => '/article/create',
				'/article/update' => '/article/update',
				'/article/' => '/article/delete',

				//comment
				'/comment' => '/comment/index',
				'/comment/<action>' => '/comment/<action>',
                // banners
                '/banner' => '/banner/index',
                '/banner/<action>' => '/banner/<action>',
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
    ],
	'modules' => [
		'user' => [
			'class' => 'budyaga\users\Module',
			'userPhotoUrl' => 'http://example.com/uploads/user/photo',
			'userPhotoPath' => '@frontend/web/uploads/user/photo'
		]
	],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.*.*' ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.*.*' ]
    ];
}

return $config;
