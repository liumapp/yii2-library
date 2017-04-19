<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017/1/18
 * Time: 17:18
 */

namespace liumapp\library\widgets;


use huluwa\vis\assets\JQueryVisAsset;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class VisRelation extends Widget
{

    /**
     * 根节点
     * @var array
     */
    public $node;

    /**
     * 选中的节点
     * @var array
     */
    public $selected=[];

    /**
     * 整个家族
     * @var array
     */
    public $family=[];

    /**
     * 家族成员关系
     * @var array
     */
    public $links=[];

    /**
     * 小部件选项
     * @var array
     */
    public $options;

    public function run()
    {
        JQueryVisAsset::register($this->getView());
        $this->clientOptions['nodes'] = $this->getData();
        $this->clientOptions['links'] = $this->getLinks();
        $this->registerPlugin('vis');
        return Html::tag('div', '', $this->options);
    }

    protected function getData()
    {
        $data = [];
        foreach($this->family as $child){
            $item = [
                'id'=>$child['name'],
                'label'=>$child['title'],
                'shape'=>'box'
            ];
            if (is_array($this->selected) && in_array($child['name'],$this->selected)){
                $item['color'] = 'orange';
            }
            $data[] = $item;
        }
        return $data;
    }

    protected function getLinks()
    {
        $reLinks = [];
        $nodes = $this->family;
        foreach($this->links as $link){
            $reLinks[]=[
                'from'=>$nodes[$link['child']]['name'],
                'to'=>$nodes[$link['parent']]['name'],
                'arrows'=>'to'
            ];
        }
        return $reLinks;
    }
}