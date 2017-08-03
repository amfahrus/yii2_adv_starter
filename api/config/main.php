<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
			      'loginUrl' => null,
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
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
					'pluralize' => false,
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/customer',
                    'extraPatterns' => [
                        'POST profile' => 'profile',
                        'GET status' => 'status',
                        'GET detail' => 'detail',
                        'POST add' => 'add',
                        'POST upd' => 'upd',
                        'GET del' => 'del',
                        'GET hours' => 'hours',
                        'GET prices' => 'prices',
                        'GET latlng' => 'latlng',
                        'GET capacity' => 'capacity',
                        'GET address' => 'address',
                    ],
                    //'tokens' => [
                    //    '{id}' => '<id:\\w+>'
                    //]

                ],
                [
					'pluralize' => false,
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/auth',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST signup' => 'signup',
                        'GET logout' => 'logout',
                        'POST reset' => 'reset',
                    ],
                ],
            ],
        ]
    ],
    'params' => $params,
];
