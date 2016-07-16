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
$urlManager = include(__DIR__ . '/urlManager.php');

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
		'urlManager' => $urlManager,
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
					'logVars' => [],
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
