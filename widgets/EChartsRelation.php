<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/23
 * Time: 14:27
 */

namespace liumapp\library\widgets;


use huluwa\echarts\assets\JQueryEChartsAsset;
use liumapp\library\assets\EChartsAsset;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * 节点的家族之间的关系
 * Class EChartsRelation
 * @package liumapp\library\widgets
 */
class EChartsRelation extends Widget
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

    public $size = 50;

    public $shape = 'circle';

    public function run()
    {
        JQueryEChartsAsset::register($this->getView());
        $eChartOptions = [
            //'title' => ['text' => '关系图'],
            'tooltip' => new \stdClass(),
            'animationDurationUpdate' => 1500,
            'animationEasingUpdate' => 'quinticInOut',
            'series' => [
                [
                    'type' => 'graph',
                    'layout' => 'circular',
                    'symbol' => $this->shape,
                    'symbolSize' => $this->size,
                    'label' => [
                        'normal' => [
                            'show' => true,
                            'textStyle'=>['fontSize'=>12]
                        ]
                    ],
                    'edgeSymbol' => ['none', 'arrow'],
                    'edgeSymbolSize' => [10, 10],
                    'edgeLabel' => [
                        'normal' => [
                            'textStyle' => ['fontSize' => 12]
                        ]
                    ],
                    'data' => $this->getData(),
                    'links' => $this->getLinks(),
                    'lineStyle' => [
                        'normal' => [
                            'opacity' => 0.9,
                            'width' => 2,
                            'curveness' => 0
                        ]
                    ]
                ]
            ]

        ];
        $this->clientOptions = ArrayHelper::merge($eChartOptions,$this->clientOptions);
        $this->registerPlugin('echarts');
        return Html::tag('div', '', $this->options);
    }

    protected function getData()
    {
        $data = [];
        foreach($this->family as $child){
            $item = [
                'name'=>$child['title'],
                'value'=>$child['name'],
                'itemStyle'=>[
                        'normal' => [
                        'color' => 'green'
                    ]
                ]
            ];
            if ($child['name'] == $this->node['name']) {
                $item['symbol']='diamond';
                $item['symbolSize']=60;
                //unset($item['itemStyle']);
            }
            if (is_array($this->selected) && in_array($child['name'],$this->selected)){
                $item['itemStyle']['normal']['color'] = 'darkred';
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
                'source'=>$nodes[$link['child']]['title'],
                'target'=>$nodes[$link['parent']]['title'],
            ];
        }
        return $reLinks;
    }
}