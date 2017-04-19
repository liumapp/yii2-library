<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/7 0007
 * Time: 下午 3:05
 */

namespace liumapp\library\helpers;

use yii\db\Query;
use yii\helpers\ArrayHelper;

class ModelHelper
{
    /**
     * string to array_map
     * ```php
     *  $str="a:b\nc:d";
     *  ['a'=>'b','c'=>d];
     * ```php
     * @param $string
     * @param string $firstDelimiter
     * @param string $secondDelimiter
     * @return array
     */
    public static function str2map($string,$firstDelimiter="\n",$secondDelimiter=":"){
        $items = explode($firstDelimiter,$string);
        $map = [];
        foreach($items as $item) {
            $kv = explode($secondDelimiter,$item);
            if (count($kv)==2) {
                $map[$kv[0]] = $kv[1];
            }
        }
        return $map;
    }
    public static function getUploadImage($key,$thumbnail=false) {
        if ($thumbnail == true) {
            $name = basename($key);
            $key = dirname($key) . '/thumbnail_' . $name;
        }
        $baseUrl = \Yii::$app->params['uploadBaseUrl'];
        return $baseUrl . $key;
    }

    public static function getLocalImage($key,$thumbnail=false) {
        return \Yii::getAlias('@data/' . $key);
    }
    /**
     * @param string $status error|danger|success|warning|info
     * @param mixed $message  string or array
     */
    public static function setFlashMessage($status='success',$message='保存成功') {
        \Yii::$app->session->setFlash($status, $message);
    }
    public static function saveSuccess(){
        self::setFlashMessage();
    }

    public static function saveError(){
        self::setFlashMessage('error','保存失败');
    }
    /**
     * 生产证书编号
     * @param $formatter
     * @return mixed
     */
    public static function certificationCodeGenerator($formatter)
    {
        return preg_replace_callback('/(\w+?)\{(\w+)\}\{(\d+)\}/',function ($matches){
            return strtoupper($matches[1]) . date($matches[2],time()). self::random($matches[3]);
        },$formatter);
    }

    /**
     * 产生随机字符串
     *
     * @param    int        $length  输出长度
     * @param    string     $chars   可选的 ，默认为 0123456789
     * @return   string     字符串
     */
    public static function random($length, $chars = '0123456789') {
        $hash = '';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    /**
     * 根据date 计算 startDateTime and endDateTime
     * @param $date
     * @return array
     */
    public static function dateToBetween($date){
        $startTime = strtotime($date);
        return [$startTime,$startTime + 86400];
    }

    /**
     * 根据map 找父节点路径
     * @param $treeMap
     * @param $id
     * @param string $parentField
     * @return array
     */
    public static function treePath($treeMap,$id,$parentField='pid'){
        $path=[];
            if (isset($treeMap[$id])) {
                $leaf = $treeMap[$id];
                array_unshift($path,$leaf);
                $pid = $leaf[$parentField];
                if ($pid!= 0) {
                    $leafs = self::treePath($treeMap,$pid);
                    foreach($leafs as $leaf) {
                        array_unshift($path,$leaf);
                    }
                } else {
                    if (isset($treeMap[$pid]))
                        array_unshift($path,$treeMap[$pid]);
                }
            }
        return $path;
    }
    /**
     * return array ($key=>value)
     * @param $table
     * @param string $valueField
     * @param string $keyField
     * @return array
     */
    public static function map($table,$valueField='name',$keyField='id'){
        $rows = (new Query())
            ->select([$keyField, $valueField])
            ->from($table)
            ->all();
        return ArrayHelper::map($rows, $keyField, $valueField);
    }

    /**
     * @param $models
     * @param int $id
     * @param int $level
     * @param string $idField
     * @param string $parentField
     * @return array
     */
    static public function subTree($models,$id=0,$level=1,$idField='id',$parentField='parent') {
        $subs = array();
        foreach($models as $model) {
            if($model[$parentField] == $id) {
                $model['level'] = $level;
                $subs[] = $model;
                $subs = array_merge($subs,self::subTree($models,$model[$idField],$level+1,$idField,$parentField));
            }
        }
        return $subs;
    }


    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pk 主键
     * @param string $pid parent标记字段
     * @param string $child 子节点字段
     * @param int
     * @return array
     * @author gang.dun <dungang@huluwa.cc>
     */
    static public function listToTree($list, $pk='id', $pid = 'pid', $child = 'items', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if(is_array($list))
        {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data)
            {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data)
            {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId)
                {
                    $tree[] =& $list[$key];
                }
                else
                {
                    if (isset($refer[$parentId]))
                    {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}