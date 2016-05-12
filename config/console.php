<?php

function merge_configs($base, $customized)
{
    $baseConfig = require($base);
    if (is_file($customized))
        return yii\helpers\ArrayHelper::merge($baseConfig, require($customized));
    return $baseConfig;
}

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = merge_configs(__DIR__ . '/params.php', __DIR__ . '/params.local.php');
$db = merge_configs(__DIR__ . '/db.php', __DIR__ . '/db.local.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
			'loginUrl' => ['/login'],
		],*/
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
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
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
        'urlManager' => [
            'scriptUrl' => $params['domain'],
        ],
        'db' => $db,
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
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
