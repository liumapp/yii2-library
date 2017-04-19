<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/8
 * Time: 8:40
 */

namespace liumapp\library\widgets;


use liumapp\library\assets\ChooserAsset;
use yii\bootstrap\Html;
use yii\bootstrap\InputWidget;
use yii\helpers\ArrayHelper;

/**
 * Class Chooser
 * --
 * > 使用方式1
 * ```
 * $form->field($model, 'users')->widget(\liumapp\library\widgets\Chooser::className(),[
 *  'url'=>\yii\helpers\Url::toRoute(['/admin/admin-organization/chooser'])
 * ])
 * ```
 *
 * > 使用方式2
 * ```
 * \liumapp\library\widgets\Chooser::widget([
 *  'name'=>'users',
 *  'url'=>\yii\helpers\Url::toRoute(['/admin/admin-organization/chooser']),
 * ])
 * ```
 * @package liumapp\library\widgets
 */
class Chooser extends InputWidget
{

    public $title = '<h4>选择人员</h4>';

    public $inputOptions = [];

    public $template = "chooser";

    public $url = '';

    public function run()
    {
        ChooserAsset::register($this->getView());
        $this->options['class']='chooser';
        $this->clientOptions['url'] = $this->url;
        $this->registerPlugin('chooser');
        return Html::tag('div', $this->render($this->template, [
            'input' => $this->renderInput(),
            'id'=>$this->options['id'],
            'title'=>$this->title,
        ]), $this->options);
    }

    protected function renderInput()
    {
        $options = ArrayHelper::merge(['id'=>$this->options['id'] . '-hidden'],$this->inputOptions);
        if ($this->hasModel()) {
            return Html::activeHiddenInput($this->model, $this->attribute,$options);
        } else {
            return Html::hiddenInput($this->name, $this->value,$options);
        }
    }

}