<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/29 0029
 * Time: 下午 2:31
 */

namespace liumapp\library\helpers;

use yii\swiftmailer\Mailer;
class MailHelper
{

    /**
     * @var \yii\swiftmailer\Mailer
     */
    private static $mailer;

    /**
     * @var string
     */
    public static $email;


    /**
     * 获取邮件实例
     * @return object|Mailer
     * @throws \yii\base\InvalidConfigException
     */
    public static function Instance()
    {
        if(self::$mailer){
            return self::$mailer;
        }
        $setting = \Yii::$app->settingParam;
        self::$email = $setting->get('email.account');
        return self::$mailer = \Yii::createObject( [
            'class' => Mailer::className(),
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $setting->get('email.smtp.host'),
                'username' => self::$email,
                'password' => $setting->get('email.password'),
                'port' => $setting->get('email.smtp.port'),
                'encryption' => $setting->get('email.smtp.ssl')==1?'ssl':false,
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [self::$email => 'admin']
            ],
        ]);

    }
}