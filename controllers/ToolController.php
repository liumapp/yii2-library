<?php


namespace liumapp\library\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use liumapp\library\helpers\ModelHelper;

class ToolController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    ['roles'=>['admin'],'allow' => true,]
                ]
            ],
        ];
    }

    public function actionCleanCache()
    {
        \Yii::$app->cache->flush();
        ModelHelper::setFlashMessage('success','缓存清理成功');
        $this->goBack();
    }

}