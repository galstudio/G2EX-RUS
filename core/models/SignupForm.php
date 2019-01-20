<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const ACTION_SIGNUP = 'signup';
    const ACTION_AUTH_SIGNUP = 'auth-signup';

    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $invite_code;
    public $action;
    public $captcha;
    private $_inviteCode = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['username', 'email', 'invite_code'], 'trim'],
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            ['username', 'match', 'pattern' => User::USERNAME_PATTERN, 'message' => 'используйте буквы (a-z) и/или цифры (0-9)'],
//            ['username', 'string', 'length' => [4, 20]],
            ['username', 'validateMbString'],
            ['username', 'validateFilter'],
            ['email', 'email'],
            ['password', 'string', 'length' => [6, 16]],
            ['password_repeat', 'compare', 'skipOnEmpty'=>false, 'compareAttribute'=>'password', 'message' => 'Пароли не совпадают'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой логин уже зарегистрирован'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой Email уже зарегистрирован'],
            ['invite_code', 'validateInviteCode'],
        ];
        if($this->action !== self::ACTION_AUTH_SIGNUP && intval(Yii::$app->params['settings']['captcha_enabled']) === 1) {
            $rules[] = ['captcha', 'captcha'];
        }
        if(intval(Yii::$app->params['settings']['close_register']) === 2) {
            $rules[] = ['invite_code', 'required'];
        }
        return $rules;
    }

    public function validateMbString($attribute, $params)
    {
        $len = strlen(preg_replace("/[\x{4e00}-\x{9fa5}]/u", '**', $this->$attribute));
        if ($len<4 || $len>16) {
            $this->addError($attribute, 'Длина логина должна быть от 4 до 16 знаков');
        }
    }

    public function validateFilter($attribute, $params)
    {
        if( empty(Yii::$app->params['settings']['username_filter']) ) {
            return;
        }
        $filters = explode(',', Yii::$app->params['settings']['username_filter']);
        foreach($filters as $filter) {
            $pattern = str_replace('*', '.*', $filter);
            $result = preg_match('/^' . $pattern . '$/is', $this->$attribute);
            if ( !empty($result) ) {
                $this->addError($attribute, 'Логин не может содержать '. str_replace('*', '', $filter));
                return;
            }
        }
    }

    public function validateInviteCode($attribute, $params)
    {
        $this->_inviteCode = Token::find()
                    ->where(['token'=>$this->$attribute, 'type'=>Token::TYPE_INVITE_CODE])
                    ->one();
        if (!$this->_inviteCode) {
            $this->addError($attribute, 'Неверный код');
        } else if ($this->_inviteCode->status != Token::STATUS_VALID) {
            $this->addError($attribute, 'Этот код уже был использован');
        } else if ($this->_inviteCode->expires > 0 && $this->_inviteCode->expires < time()) {
            $this->addError($attribute, 'Срок действия этого кода истек');
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль еще раз',
            'invite_code' => 'Инвайт',
            'captcha' => 'Код',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->score = User::getCost('reg');
            $user->avatar = 'avatar/0_{size}.png';
            if ( $this->action != self::ACTION_AUTH_SIGNUP ) {
                if (intval(Yii::$app->params['settings']['email_verify']) === 1) {
                    $user->status = User::STATUS_INACTIVE;
                } else if (intval(Yii::$app->params['settings']['admin_verify']) === 1) {
                    $user->status = User::STATUS_ADMIN_VERIFY;
                } else {
                    $user->status = User::STATUS_ACTIVE;
                }
            } else {
                $user->status = User::STATUS_ACTIVE;
            }
            if ($user->save()) {
                if( $this->_inviteCode ) {
                    $this->_inviteCode->status = Token::STATUS_USED;
                    $this->_inviteCode->ext = json_encode(['id'=>$user->id, 'username'=>$user->username]);
                    $this->_inviteCode->save();
                }
                if ( $this->action != self::ACTION_AUTH_SIGNUP && intval(Yii::$app->params['settings']['email_verify']) === 1) {
                    Token::sendActivateMail($user);
                }
                return $user;
            }
        }

        return null;
    }
}
