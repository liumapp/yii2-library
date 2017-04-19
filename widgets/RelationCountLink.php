<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/9
 * Time: 17:50
 */

namespace liumapp\library\widgets;


use liumapp\library\assets\RelationCountAsset;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class RelationCountLink extends Widget
{
    /**
     * @var string blue|red|aqua|green
     */
    public $color = 'red';

    public $tag = 'li';

    public $title;

    /**
     * @var array
     */
    public $route;

    public $countUrl;

    /*
     * [
     *  'md'=>'app/modules/product/models/Product',
     *  'params'=>['isDel'=>0,'categoryId'=>'2']
     * ]
     * @var array
     */
    //public $clientOptions;


    public function run()
    {

        $this->clientOptions = array_merge([
            'color'=>$this->color,
            'url'=>Url::toRoute($this->countUrl)
        ],$this->clientOptions);
        RelationCountAsset::register($this->getView());
        $this->registerPlugin('relationCount');
        return Html::tag($this->tag,Html::a($this->title,$this->route),$this->options);

    }
}