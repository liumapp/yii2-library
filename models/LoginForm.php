<?php
namespace liumapp\library\models;

use huluwa\geetest\validators\CaptchaValidator;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $userName;
    public $password;
    public $rememberMe = true;
    public $verifyCode;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['verifyCode', CaptchaValidator::className()],
            //['verifyCode', 'captcha','captchaAction'=>'/admin/default/captcha'],
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
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[userName]]
     *
     * @return Admin|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Admin::findByUsername($this->userName);
        }

        return $this->_user;
    }
}
