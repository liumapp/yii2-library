<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/9
 * Time: 16:06
 */

namespace liumapp\library\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class batchDelete
 * @package liumapp\library\widgets
 * @TODO 批量删除
 */
class BatchDelete extends Widget
{
    /**
     * @var url ,path to actionDelete,eg: /attachment/default/delete
     */
    public $url;

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        $url = \Yii::$app->controller->route;
        $routeArr = explode('/', $url);
        array_pop($routeArr);
        $deleteAction = $this->url?$this->url:Url::toRoute('/' . implode('/', $routeArr) . '/delete');
        $js = new JsExpression(
            '$(".gridview").on("click", function () {
            var keys = $(".grid-view").yiiGridView("getSelectedRows");
            if(keys.length==0){
                    alert("请至少选择一条记录");
            }
            for(i in keys){
                $.post("' . $deleteAction . '&id="+keys[i],{},function(){})
            }
        });');
        echo Html::a("批量删除", "javascript:void(0);", ["class" => "btn btn-success gridview"]);
        $this->view->registerJs($js);
    }

}