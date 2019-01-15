<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expired_at
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'tokens';
  }
  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      [['user_id', 'token'], 'required'],
      [['user_id'], 'integer'],
      [['expired_at'], 'safe'],
      [['token'], 'string', 'max' => 255],
      [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
    ];
  }

  public function getId0()
  {
    return $this->hasOne(User::className(), ['id' => 'id']);
  }

  public static function find()
  {
    return new TokenQuery(get_called_class());
  }
  public function generateToken($expire)
  {
    $this->expired_at = $expire;
    $this->token = \Yii::$app->security->generateRandomString();
  }
}
