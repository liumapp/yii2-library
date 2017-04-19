<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/9
 * Time: 17:05
 */

namespace liumapp\library\actions;


use yii\base\Action;
use yii\db\Query;
use yii\helpers\Json;

class RelationCountAction extends Action
{
    /**
     * @param $md string 模型
     * @return string
     */
    public function run($md)
    {
        $gets = \Yii::$app->request->get();
        unset($gets['md']);
        unset($gets['r']);
        $count = (new Query())
            ->from($md::tableName())
            ->where($gets)
            ->count();
        return Json::encode([
            'count'=>$count,
        ]);
    }
}