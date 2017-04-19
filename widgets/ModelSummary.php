<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/12
 * Time: 8:39
 */

namespace liumapp\library\widgets;


use yii\bootstrap\Html;
use yii\bootstrap\Widget;

class ModelSummary extends Widget
{

    /**
     * @var array
     */
    public $links = [];

    public $tag = 'ul';

    public function run()
    {
        $summary = '';
        foreach($this->links as $link){
            $summary .= RelationCountLink::widget($link);
        }
        if ($summary) {
            return Html::tag($this->tag,$summary,$this->options);
        }
        return '';

    }

}