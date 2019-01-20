<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;

/**
 * Email reset form
 */
class ChangeEmailForm extends \yii\base\Model
{
    const SCENARIO_VERIFY_EMAIL = 2;

    public $password;
    public $email;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_VERIFY_EMAIL] = ['email'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            ['email', 'trim'],
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string', 'length' => [6, 16]],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => '申请绑定邮箱已被注册使用'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Новый Email',
            'password' => 'Ваш пароль',
        ];
    }

	public function apply()
	{
		$user = Yii::$app->getUser()->getIdentity();
		if ( !$user->validatePassword($this->password) ) {
			return ['chgEmailNG', 'Неверный пароль'];
		} else if ( $user->email === $this->email ) {
			return ['chgEmailNG', 'Новый и текущий Email не могут быть олдинаковыми'];
		} else if ( !$this->validate() ) {
			return ['chgEmailNG', implode('<br />', $this->getFirstErrors())];
		} else if ( !self::sendEmail() ) {
			return ['chgEmailNG', 'Ошибка отправки сообщения, попробуйте снова или обратитесь к администрации ('.Yii::$app->params['settings']['admin_email'].')'];
		} else {
			return ['chgEmailOK', 'Сообщение активации было отправлено на ваш новый Email.'];
		}
	}

    public function sendEmail()
	{
        $user = Yii::$app->getUser()->getIdentity();
		if( intval($user->status) === User::STATUS_INACTIVE ) {
			return Token::sendActivateMail($user, $this->email);
		} else {
			return self::sendChangeEmail($user->id);
		}
	}

    public function sendChangeEmail($user_id)
    {
		$token = Token::findByType(Token::TYPE_EMAIL, $user_id, $this->email);
		$rtnCd = false;
		if ( $token ) {
			$settings = Yii::$app->params['settings'];

			try {
		        $rtnCd = Yii::$app->getMailer()->compose(['html' => 'emailChangeToken-text'], ['token' => $token])
	                ->setFrom([$settings['mailer_username'] => $settings['site_name']])
	                ->setTo($this->email)
	                ->setSubject($settings['site_name']. ' подтвержение изменения почтового ящика')
	                ->send();
			} catch(\Exception $e) {
				return false;
			}

			(new History([
				'user_id' => $user_id,
				'action' => History::ACTION_CHANGE_EMAIL,
				'ext' => $this->email,
			]))->save(false);
		}

        return $rtnCd;
    }

}
