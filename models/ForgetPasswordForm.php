<?php
namespace liumapp\library\models;

use liumapp\library\helpers\MailHelper;
use liumapp\library\validators\CaptchaValidator;
use Yii;
use yii\base\Model;
/**
 * Password reset request form
 */
class ForgetPasswordForm extends Model
{

    /**
     * @var string
     */
    public $userName;
    public $verifyCode;

    /**
     * @var \liumapp\library\Models\Admin
     */
    protected $_admin;

    public function rules()
    {
        return [
            [['userName','verifyCode'],'required'],
            ['verifyCode', CaptchaValidator::className()],
            ['userName', 'exist'],
        ];
    }

    public function exist($attribute, $params)
    {
        if(!$this->hasErrors() && !$this->_admin = Admin::findOne([$attribute=>$this->userName]))
        {
            $this->addError($attribute, '帐号不存在.');
        }
    }

    /**
     * 发送修改密码邮件
     * @return bool
     */
    public function sendEmail()
    {
        $this->_admin->generatePasswordResetToken();
        if ($this->_admin->save()){
            return MailHelper::Instance()
                ->compose(
                    ['html' => 'backendPasswordResetToken-html', 'text' => 'backendPasswordResetToken-text'],
                    ['user' => $this->_admin]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->_admin->email)
                ->setSubject('Password reset for ' . Yii::$app->name)
                ->send();
        }
        return false;
    }

}
