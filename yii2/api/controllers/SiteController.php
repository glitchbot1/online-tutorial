<?php
namespace api\controllers;

use Yii;

//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use api\models\LoginForm;
use common\models\Token;
use yii\rest\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

    public function actionIndex()
    {
        return 'api';
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        //bodyParams захватывает все пареметры (post,put и тд)
        $model->load(Yii::$app->request->bodyParams,'');
        if ($token = $model->auth()) {
          return [

            'token' =>$token->token,
            'expired' =>date(DATE_RFC3339, $token->expired_at),
          ];
        }
        else {
          return $model;
        }
    }

    public function verbs()
    {
        return [

          'login' => ['post'],

        ];


    }
}
