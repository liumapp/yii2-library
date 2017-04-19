<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/9
 * Time: 9:22
 */

namespace liumapp\library\widgets\ui;


use liumapp\library\assets\ZTreeAsset;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class ZTree extends Widget
{
    /**
     * 选中节点
     * @var array
     */
    public $checkedIds = [];

    /**
     * 节点数据
     * @var array
     */
    public $nodes = [];

    /**
     * 默认是否全部展开
     * @var bool
     */
    public $expandAll=false;

    /**
     * 是否支持pjax,配制YII2的pjax的配置表示支持pjax的功能
     * @var bool|array
     */
    public $pJaxOptions = false;
    /**
     * [
     *  'class'=>'app/product/models/Category',
     *  'filter'=>['isDel'=>0],
     *  'select'=>[],
     *  'order'=>[],
     *  'route'=>['/product/default/index','d'=>1],
     *  'paramName'=>'categoryId',
     * ]
     * @var bool|array
     */
    public $nodeSource = false;

    public function run()
    {
        $view = $this->getView();
        ZTreeAsset::register($view);
        $id = $this->options['id'];
        if (is_array($this->nodeSource)){
            $this->nodes = $this->dateSource();
        }
        $this->nodes = Json::encode($this->nodes);
        $this->clientOptions = ArrayHelper::merge([
            'data'=>[
                'simpleData'=>['enable'=>true]
            ]
        ],$this->clientOptions);

        $options = empty($this->clientOptions) ? '{}' : Json::htmlEncode($this->clientOptions);
        $js = "var tree$id = $.fn.zTree.init(jQuery('#$id'),$options,$this->nodes);";
        if ($this->expandAll){
            $js .= " tree$id.expandAll(true);";
        }
        if(!empty($this->checkedIds))
        {
            foreach($this->checkedIds as $tid){
                $js .= " tree$id.selectNode(tree$id.getNodeByParam(\"id\", $tid, null));";
            }
        }
        if ($this->pJaxOptions){
            $this->pJaxOptions = array_merge([
                'push'=>true,
                'replace'=>false,
                'timeout'=>1000,
                'scrollTo'=>false,
            ],$this->pJaxOptions);
            $pjaxOptions = Json::htmlEncode($this->pJaxOptions);
            $js .= " jQuery(document).pjax('#$id a',$pjaxOptions);";
        }
        $view->registerJs($js);

        $this->options['class']='ztree';
        return Html::tag('div','',$this->options);
    }

    protected function dateSource()
    {
        $source = ArrayHelper::merge([
            'select'=>['id','pid as pId','name'],
            'paramName'=>'id',
            'order'=>false,
        ],$this->nodeSource);
        $class = $source['class'];
        $nodes = (new Query())->select($source['select'])
            ->from($class::tableName())
            ->where($source['filter'])
            ->orderBy($source['order'])
            ->all();
        foreach($nodes as &$node){
            if (!empty($source['route'])){
                $source['route'][$source['paramName']] = $node['id'];
                $node['url'] = Url::toRoute($source['route']);
            }
            if (in_array($node['id'],$this->checkedIds)){
                $node['checked']=true;
            }
        }
        return $nodes;
    }
}