<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\captcha\Captcha;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;
    public $verifyCode;

    private $_user;

    const SCENARIO_BADLOGINCOUNT = 'badLoginCount';


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login', 'password'], 'required'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],

            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'skipOnEmpty'=>!Captcha::checkRequirements(), 'on'=>self::SCENARIO_BADLOGINCOUNT],

            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t("app", "Incorrect username or password."));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[login]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByLogin($this->login);
        }
        return $this->_user;
    }

    public function attributeLabels() {
        return [
            'login'=>Yii::t("app", 'Login'),
            'password'=>Yii::t("app", 'Password'),
            'rememberMe'=>Yii::t("app", 'Remember me'),
            'verifyCode'=>Yii::t("app", 'Captcha'),
        ];
    }
}
