<?php
namespace api\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use common\models\User;
use common\models\Token;
use api\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function behaviors()
    {
        return [
          'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
              'Origin' => ['*'],
              'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
              'Access-Control-Request-Headers' => ['*'],
            ]
          ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index',],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['post','options'],
                ],
            ],
        ];
    }
    public function  beforeAction($action)
    {
      if (in_array($action->id,['index'])) {
        $this->enableCsrfValidation = false;
      }
      return parent::beforeAction($action);
    }

  public function actionIndex()
    {
      //отключаем цсрф чтобы не иметь 400 ошибки при запросе
      $this->enableCsrfValidation = false;

      $params = Yii::$app->request->getBodyParams();

      $user = User::findByEmail(Yii::$app->request->getBodyParam('login'));
        if (!$user)
          $result =  [
            'success' => 0,
            'message' => 'No such user found'
          ];

      if($user)
        if (!$user->validatePassword(Yii::$app->request->getBodyParam('password'))) {
          $result =   [
            'success' => 0,
            'message' => 'Incorrect password'
          ];
        }
        else{
          $token = new Token();
          $token->token = Yii::$app->getSecurity()->generateRandomString(12);
          $token->user_id = $user->id;
          $token->expired_at = time() + 3600 * 5;
          $token->save();
          Token::deleteAll('expire_time < ' . time());
          $result =   [
            'success' => 1,
            'username' =>  $user->username,
            'payload' => $user,
            'token' => $token->token
          ];
        }
      echo json_encode($result);
}

}
