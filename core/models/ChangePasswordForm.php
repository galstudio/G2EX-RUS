<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;

/**
 * Password reset form
 */
class ChangePasswordForm extends \yii\base\Model
{
    public $old_password;
    public $password;
    public $password_repeat;
    private $_user;

    public function rules()
    {
        return [
            [['old_password', 'password', 'password_repeat'], 'required'],
            ['password', 'string', 'length' => [6, 16]],
            ['password', 'compare', 'compareAttribute'=>'old_password', 'operator' => '!=', 'message' => 'Новый и текущий пароли не должны совпадать'],
            ['password_repeat', 'compare', 'skipOnEmpty'=>false, 'compareAttribute'=>'password', 'message' => 'Поля нового пароля не совпадают'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'old_password' => 'Текущий пароль',
            'password' => 'Новый пароль',
            'password_repeat' => 'Новый еще раз',
        ];
    }

    public function savePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);

        if ( ($rtnCd = $user->save()) ) {
            (new History([
                'user_id' => $user->id,
                'action' => History::ACTION_CHANGE_PWD,
                'action_time' => $user->updated_at,
                'ext' => '',
            ]))->save(false);
        }

        return $rtnCd;
    }

    public function apply()
    {
        $this->_user = Yii::$app->getUser()->getIdentity();

        if ( !$this->validate() ) {
            $result = ['chgPwdNG', implode('<br />', $this->getFirstErrors())];
        } else if ( !$this->_user->validatePassword($this->old_password) ) {
            $result = ['chgPwdNG', 'Неверный текущий пароль'];
        } else if ( !$this->savePassword() ) {
            $result = ['chgPwdNG', 'Ошибка программы, попробуйте еще раз'];
        } else {
            $result = ['chgPwdOK', 'Пароль был успешно изменен!'];
        }
        return $result;
    }
}
