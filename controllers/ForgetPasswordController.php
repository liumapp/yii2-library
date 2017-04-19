<?php

namespace liumapp\library\controllers;


use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use liumapp\library\models\ForgetPasswordForm;
use liumapp\library\models\ResetPasswordForm;

class ForgetPasswordController extends Controller
{

    public $layout = 'main-login';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * 发送找回密码邮件
     * @return string|\yii\web\Response
     */
    public function actionIndex(){
        $sender = new ForgetPasswordForm();
        if($sender->load(Yii::$app->request->post())&& $sender->validate()) {
            if ($sender->sendEmail()) {
                Yii::$app->session->setFlash('success', '修改密码的邮件已经成功过发送，请检查您的邮箱!');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '抱歉，发送邮件失败！请与管理员联系，确认您的账号保存了正确的邮箱地址！');
            }
        }
        else{
            return $this->render('index',['model' => $sender]);
        }
    }

    public function actionReset($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }
        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}