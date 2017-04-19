<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/1/16
 * Time: 21:45
 */

namespace liumapp\library\controllers;


use yii\web\Controller;

class GeetestDefaultController extends Controller
{

    public function actionIndex()
    {
        $get = \Yii::$app->request->get();
        $config = \Yii::$app->params['geetest'];
        if ($get['type'] == 'mobile') {
            $gt = new \GeetestLib($config['appMobileId'], $config['appMobileKey']);
        } else {
            $gt = new \GeetestLib($config['appPcId'], $config['appPcKey']);
        }
        $status = $gt->pre_process($config['userId']);
        \Yii::$app->session->set('gt_server', $status);
        return $gt->get_response_str();
    }

}