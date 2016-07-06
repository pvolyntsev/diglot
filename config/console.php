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
			'clients' => $params['authClientCollection.clients'],
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
        'urlManager' => $urlManager, 
        [
            'showScriptName' => false,     // Disable index.php
            'enablePrettyUrl' => true,     // Disable ?r= routes
            'enableStrictParsing' => false, // Only routes being listed in rules

            'scriptUrl' => $params['domain'],
//			'baseUrl' => 'http://www.diglot.example.com/',
			'baseUrl' => $params['domain'], //'http://l.diglot.copist.ru/',
            'rules' => [
                //article
                '/article' => '/article/index',
                '/article/<action>' => '/article/<action>',
                '/article/add-comment' => '/article/addComment',
                '/article/update-comment' => '/article/updateComment',
                '/article/delete-comment' => '/article/DeleteComment',
                '/article/<action>/<id:\d+>' => '/article/<action>',
                '/search' => '/article/search',

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
    ],
	'modules' => [
		'user' => [
			'class' => 'budyaga\users\Module',
			'userPhotoUrl' => 'http://example.com/uploads/user/photo',
			'userPhotoPath' => '@frontend/web/uploads/user/photo'
		],
        'markdown' => [
            'class' => 'kartik\markdown\Module',
        ]
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
