<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/21
 * Time: 10:06
 */

namespace liumapp\library\widgets;


use huluwa\echarts\assets\JQueryEChartsAsset;
use liumapp\library\models\Node;
use liumapp\library\models\ItemChild;
use yii\bootstrap\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class RoleRelationChart extends Widget
{

    public $options;

    public $size = 60;

    public $shape = 'circle';

    public $assignedRoles=[];

    public $allRoles;

    public function run()
    {
        JQueryEChartsAsset::register($this->getView());
        $roles = $this->getAllRoles();
        $eChartOptions = [
            'title' => ['text' => '关系图'],
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
                    'edgeSymbol' => ['arrow', 'none'],
                    'edgeSymbolSize' => [10, 10],
                    'edgeLabel' => [
                        'normal' => [
                            'textStyle' => ['fontSize' => 20]
                        ]
                    ],
                    'data' => $this->data($roles),
                    'links' => $this->links($roles),
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

    protected function getAllRoles()
    {
        if ($this->allRoles){
            return $this->allRoles;
        }
        return (new Query())->select('name,title')
            ->from(Node::tableName())
            ->where(['type' => Node::TYPE_ROLE])
            ->indexBy('name')
            ->all(Node::getDb());
    }

    protected function data($nodes)
    {
        $data = [];
        foreach ($nodes as $node) {
            $item = [
                'name' => $node['title'],
                'value' => $node['name'],
            ];
            if (!in_array($node['name'], $this->assignedRoles)) {
                $item['itemStyle'] = [
                    'normal' => [
                        'color' => 'green'
                    ]
                ];
            }
            $data[] = $item;
        }
        return $data;
    }

    protected function links($nodes)
    {
        $names = [];
        foreach($nodes as $node){
            $names[] = $node['name'];
        }
        return (new Query())->select('nn.title as source,n.title as target')
            ->from(['c' => ItemChild::tableName(), 'n' => Node::tableName(), 'nn' => Node::tableName()])
            ->where("c.child = n.name and c.parent = nn.name")
            ->andWhere(['n.type' => Node::TYPE_ROLE, 'nn.type' => Node::TYPE_ROLE, 'c.child' => $names, 'c.parent' => $names])
            ->all();
    }

}