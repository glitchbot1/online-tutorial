<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'parser' => [
              'application/json ' => 'yii\web\JsonParser',
              'text/xml' => 'yii\web\XmlParser'
            ],
        ],
        'response' => [
          'formatters' => [
            'json' => [
              'class' => 'yii\web\JsonResponseFormatter',
              'prettyPrint'=> YII_DEBUG,
              'encodeOptions'=> JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
          ],

        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
//        ],
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing'=> true,
          'rules' => [
            ['class' => 'yii\rest\UrlRule', 'controller' => ['user']],
            'POST site' => 'site/index',
          ],
        ],
    ],
    'params' => $params,
];
