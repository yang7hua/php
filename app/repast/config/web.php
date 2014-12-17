<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language'	=>	'zh-cn',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '594VAwOdE5RlSzXg_mMjUZSzbFdhQKCC',
        ],
		'view'	=>	[
			'theme'	=>	[
				'pathMap'	=>	[
					'@app/views'	=>	[
						'@app/themes/basic'
					]
				]
			]	
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\user\User',
            'enableAutoLogin' => true,
        ],
		'site'	=>	'app\models\Site',
		'util'	=>	'app\vendor\util\util',
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
		'urlManager'	=>	require(__DIR__ . '/url.php')
    ],
    'params' => $params,

	//默认路由
	'defaultRoute'	=>	'site/index',

	//捕获所有路由
	//'catchAll'	=>	['site/offline'],	
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
