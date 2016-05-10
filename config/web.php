<?php

$params = require(__DIR__ . '/params.php');

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
			'identityClass' => 'budyaga\users\models\User',
			'enableAutoLogin' => true,
			'loginUrl' => ['/login'],
		],
		'authClientCollection' => [
			'class' => 'yii\authclient\Collection',
			/*
			'clients' => [
				'vkontakte' => [
					'class' => 'budyaga\users\components\oauth\VKontakte',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
					'scope' => 'email'
				],
				'google' => [
					'class' => 'budyaga\users\components\oauth\Google',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
				],
				'facebook' => [
					'class' => 'budyaga\users\components\oauth\Facebook',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
				],
				'github' => [
					'class' => 'budyaga\users\components\oauth\GitHub',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
					'scope' => 'user:email, user'
				],
				'linkedin' => [
					'class' => 'budyaga\users\components\oauth\LinkedIn',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
				],
				'live' => [
					'class' => 'budyaga\users\components\oauth\Live',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
				],
				'yandex' => [
					'class' => 'budyaga\users\components\oauth\Yandex',
					'clientId' => 'XXX',
					'clientSecret' => 'XXX',
				],
				'twitter' => [
					'class' => 'budyaga\users\components\oauth\Twitter',
					'consumerKey' => 'XXX',
					'consumerSecret' => 'XXX',
				],
			],
			*/
		],
		'urlManager' => [
            'showScriptName' => false,     // Disable index.php
            'enablePrettyUrl' => true,     // Disable ?r= routes
            'enableStrictParsing' => true, // Only routes being listed in rules
			'rules' => [
                // Main page & static pages
                '/' => 'site/index',

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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    ],
	'modules' => [
		'user' => [
			'class' => 'budyaga\users\Module',
			'userPhotoUrl' => 'http://example.com/uploads/user/photo',
			'userPhotoPath' => '@frontend/web/uploads/user/photo'
		],
	],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
