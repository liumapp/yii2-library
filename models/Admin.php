<?php

namespace liumapp\library\models;

use Yii;
use yii\base\NotSupportedException;
use liumapp\library\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $userName
 * @property string $password
 * @property string $passwordResetToken
 * @property string $authKey
 * @property string $realName
 * @property string $email
 * @property string $telephone
 * @property string  $photo
 * @property integer $status
 * @property string $shortcutMenu
 * @property integer $isDel
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public static $statusMap = [
        '0'=>'禁用',
        '1'=>'可用'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName','realName', 'status','email'], 'required'],
            [['status'], 'integer'],
            [['userName'], 'string', 'max' => 24],
            [['telephone'],'number'],
            [['password'], 'string', 'max' => 60],
            [['realName'], 'string', 'max' => 32],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userName' => '用户名',
            'password' => '密码',
            'realName' => '真实姓名',
            'email' => 'Email',
            'telephone' => '手机',
            'photo' => '照片',
            'status' => '启用',
            'createdAt' => '添加时间',
            'updatedAt' => '更新时间',
        ];
    }

 
    public function isSuper()
    {
        return self::super($this->id);
    }

    public static function super($adminId)
    {
        $app = \Yii::$app;
        if(isset($app->params['superAdminId']) &&
            $app->params['superAdminId'] == $adminId) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //只运行激活的，没有删除的用户登录
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE,'isDel'=>0]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        //只运行激活的，没有删除的用户登录
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE,'isDel'=>0]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }

    public static function getMap() {
        $admin = (new Query())->select(['id','realName'])
            ->from(Admin::tableName())
            ->where(['isDel'=>0])
            ->all();
        return ArrayHelper::map($admin,'id','realName');
    }
}
