<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\install_update\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\History;

/**
 * Admin Signup form
 */
class AdminSignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password', 'password_repeat'], 'required'],
//            ['username', 'string', 'length' => [4, 20]],
            ['username', 'match', 'pattern' => User::USERNAME_PATTERN, 'message' => 'Используйте латиницу (a-z), или/и (0-9) цифры'],
            ['username', 'validateMbString'],
            ['email', 'email'],
            ['password', 'string', 'length' => [6, 16]],
            ['password_repeat', 'compare', 'skipOnEmpty'=>false, 'compareAttribute'=>'password', 'message' => 'Введите пароль дважды'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой логин уже существует'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Такой Email уже существует'],
        ];
    }

    public function validateMbString($attribute, $params)
    {
        $len = strlen(preg_replace("/[\x{4e00}-\x{9fa5}]/u", '**', $this->$attribute));
        if ($len<4 || $len>16) {
            $this->addError($attribute, 'Длина логина должна составлять 4-16 знаков');
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Еще раз пароль',
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
            $user->status = User::STATUS_ACTIVE;
            $user->role = User::ROLE_ADMIN;
            $user->avatar = 'avatar/0_{size}.png';
            $user->score = User::getCost('adminreg');
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
