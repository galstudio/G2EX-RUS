<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
//use app\lib\Util;

class ForgotPasswordForm extends Model
{
    public $email;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'С таким email пользователя нет.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Ваш Email',
        ];
    }

    public function apply()
    {
        if ( !self::findUser() ) {
            throw new InvalidParamException('Пользователь с таким Email не существует');
        } else if ( !self::sendEmail() ) {
            throw new InvalidParamException('Сообщение об ошибке отправлено, пожалуйста, подайте заявку повторно или свяжитесь с веб-мастером ('.Yii::$app->params['settings']['admin_email'].')');
        } else {
            return true;
        }
    }

    public function findUser()
    {
        $this->_user = User::findByEmail($this->email);
        if ( !$this->_user ) {
            return false;
        }
        return true;
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        $user = $this->_user;

        $settings = Yii::$app->params['settings'];

        $token = Token::findByType(Token::TYPE_PWD, $user->id);
        $rtnCd = false;
        if ( $token ) {
            try {
                $rtnCd = Yii::$app->getMailer()->compose('passwordResetToken-text', ['token' => $token])
                    ->setFrom([$settings['mailer_username'] => $settings['site_name']])
                    ->setTo($this->email)
                    ->setSubject($settings['site_name']. ' сброс пароля')
                    ->send();
            } catch(\Exception $e) {
                return false;
            }

            (new History([
                'user_id' => $user->id,
                'action' => History::ACTION_RESET_PWD,
                'ext' => '',
            ]))->save(false);
        }

        return $rtnCd;
    }
}
