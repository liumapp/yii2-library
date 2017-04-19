<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/27
 * Time: 19:06
 */

namespace liumapp\library\models;


use yii\db\Query;

class Node extends Item
{

    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;
    /**
     * 父节点
     * @var array
     */
    public $parents=[];

    protected $_parentNodes=[];


    /**
     * 子节点
     * @var array
     */
    public $children=[];

    protected $_childNodes=[];

    protected $_family = [];


    public function rules()
    {
        return [
            [['name','title','belong_to'],'required'],
            [['name','title','belong_to'],'string','max'=>63],
            [['category'],'string'],
            [['rule_name'],'default'],
            [['parents','children'],'each','rule'=>['string']],
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['parents'] = \Yii::t('app','Parents');
        $labels['children'] = \Yii::t('app','Children');
        return $labels;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        self::deleteFirstGenerationChildrenFromNode($this->type,$this->name);
        self::deleteFirstGenerationParentsFromNode($this->type,$this->name);

        $saveNodes = [];
        $links=[];
        if (is_array($this->parents))
            foreach($this->parents as $parent){

                //节点不成为自己的父节点
                if ($parent == $this->name)
                    continue;
                //被选中的付节点和子节点如果是同一个节点，优先父节点。子节点忽略
                //即一个节点不能同时成为另外一个节点的父节点和子节点
                if (isset($saveNodes[$parent]))
                    continue;
                $links[]=[$parent,$this->name];
                $saveNodes[$parent]=true;
            }

        if (is_array($this->children))
            foreach($this->children as $child){
                //节点不成为自己的子节点
                if ($child == $this->name)
                    continue;
                //被选中的付节点和子节点如果是同一个节点，优先父节点。子节点忽略
                //即一个节点不能同时成为另外一个节点的父节点和子节点
                if (isset($saveNodes[$child]))
                    continue;
                $links[]=[$this->name,$child];
                $saveNodes[$child]=true;
            }

        $this->batchAddNodeRelation($links);
    }

    /**
     * 批量添加节点关系
     * @param $links
     * @return int
     */
    public function batchAddNodeRelation($links){
        return self::getDb()
            ->createCommand()
            ->batchInsert(ItemChild::tableName(), ['parent', 'child'], $links)
            ->execute();
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
        $relation = ItemChild::find()
            ->where(['or',['child'=>$this->name],['parent'=>$this->name]])
            ->all(self::getDb());
        //$nodes = RBACHelper::getNodeList();
        $nodes = $this->getFamily();
        foreach($relation as $link) {
            //is child
            if ($link['parent'] == $this->name) {
                if (isset($nodes[$link['child']]) and $nodes[$link['child']]['type']==$this->type){
                    $this->children[]=$link['child'];
                    $this->_childNodes[] = $link;
                }

            }  else if ($link['child'] == $this->name) {
                if (isset($nodes[$link['parent']]) and $nodes[$link['parent']]['type']==$this->type) {
                    $this->parents[] = $link['parent'];
                    $this->_parentNodes[] = $link;
                }
            }
        }
    }

    public function getFamily()
    {
        if (!empty($this->belong_to) && empty($this->_family)) {
            $this->_family = (new Query())
                ->from(self::tableName())
                ->where(['belong_to'=>$this->belong_to])
                ->indexBy('name')
                ->all(self::getDb());
        }
        return $this->_family;
    }

    public static function findFamilyLinks($family){

        $links = [];
        $map = self::getChildrenMap();
        foreach($map as $parent=>$children){
            if (isset($family[$parent])){
                foreach($children as $child) {
                    if (isset($family[$child])) {
                        $links[] = ['parent'=>$parent,'child'=>$child];
                    }
                }
            }
        }
        return $links;
    }

    public static $nodes;

    public static function getNodes()
    {
        if (empty(self::$nodes)) {

            self::$nodes = (new Query())
                ->from(self::tableName())
                ->indexBy('name')
                ->all(self::getDb());
        }
        return self::$nodes;
    }

    /**
     * 所有节点之间的关系
     * @var array
     */
    public static $nodeRelation;

    /**
     * 获取所有节点之间的关系
     * @return array
     */
    public static function getNodeRelation()
    {
        if (empty(self::$nodeRelation))
            self::$nodeRelation = (new Query())
                ->from(ItemChild::tableName())
                ->all(self::getDb());
        return self::$nodeRelation;
    }

    /**
     * 所有节点对应的父节点映射表
     * @var array
     */
    public static $nodeParentMap;

    /**
     * 获取所有节点对应的父节点映射表
     * @return array
     */
    public static function getParentMap()
    {
        if(empty(self::$nodeParentMap))
            foreach(self::$nodeRelation as $link) {
                self::$nodeParentMap[$link['child']][]=$link['parent'];
            }
        return self::$nodeParentMap;
    }

    /**
     * 所有节点对应的父节点映射表
     * @var array
     */
    public static $nodeChildrenMap;

    /**
     * 获取所有节点对应的父节点映射表
     * @return array
     */
    public static function getChildrenMap()
    {
        if(empty(self::$nodeChildrenMap)) {
            self::getNodeRelation();
            foreach(self::$nodeRelation as $link) {
                self::$nodeChildrenMap[$link['parent']][]=$link['child'];
            }
        }
        return self::$nodeChildrenMap;
    }

    /**
     * 查找节点的所有父节点
     * 递归查找的深度最大值为1000
     * 避免出现死循环
     * 本表结构的设计有死循环的可能性
     * @param $node
     * @param $parents
     * @param int $dep
     */
    public static function findParents($node,&$parents,$dep=0){
        $map = self::getParentMap();
        if($dep == 1000) return;
        $dep++;
        if (isset($map[$node])) {
            foreach($map[$node] as $parent){
                $parents[$parent]=true;
                self::findParents($parent,$parents,$dep);
            }
        }
    }

    /**
     * 查找节点的所有子节点
     * 递归查找的深度最大值为1000
     * 避免出现死循环
     * 本表结构的设计有死循环的可能性
     * @param $nodeName
     * @param $children
     * @param int $dep
     */
    public static function findChildren($nodeName,&$children,$dep=0) {
        $map = self::getChildrenMap();
        if($dep == 1000) return;
        $dep++;
        if (isset($map[$nodeName])) {
            foreach($map[$nodeName] as $child){
                $children[$child]=true;
                self::findChildren($child,$children,$dep);
            }
        }
    }


    public static function getFirstGenerationChildren($name,$type)
    {
        $map = self::getChildrenMap();
        $names = [];
        if ( isset($map[$name])) {
            $children = $map[$name];
            $nodes = self::getNodes();
            foreach($children as $child){
                if (isset($nodes[$child])) {
                    $node = $nodes[$child];
                    if ($node['type']==$type){
                        $names[] = $child;
                    }
                }
            }
        }
        return $names;
    }

    /**
     * 对一组节点名称安装类型过滤
     * @param $nodeNames
     * @param string $type
     * @return array
     */
    public static function filterNamesByType($nodeNames,$type) {
        if (empty($nodeNames)) return [];
        $nodes = self::getNodes();
        $results = [];
        foreach($nodeNames as $name) {
            if (isset($nodes[$name]) && $nodes[$name]['type']==$type) {
                $results[]=$name;
            }
        }
        return $results;
    }


    public static function findFamily($belong_to,$nodes)
    {
        $family = [];
        foreach($nodes as $node) {
            if ($node['belong_to'] == $belong_to) {
                $family[$node['name']] = $node;
            }
        }
        return $family;
    }

    public function familyRelation()
    {
        $family = $this->getFamily();
        $names = array_keys($family);
        return (new Query())
            ->from(ItemChild::tableName())
            ->where([ 'child' => $names, 'parent' => $names])
            ->all(self::getDb());
    }


    public function getParentNodes()
    {
        return $this->_parentNodes;
    }



    public function getChildNodes()
    {
        return $this->_childNodes;
    }

    public function getFamilyArray()
    {
        $nodes = $this->getFamily();
        $array = [];
        foreach($nodes as $name=>$node){
            $array[$name] = $node['title'];
        }
        return $array;
    }

    public function getUnsignedNodes()
    {
        $nodes = $this->getFamily();
        $array = [];
        foreach($nodes as $name=>$node){
            if($name == $this->name
                or (is_array($this->parents) && in_array($name,$this->parents))
                or (is_array($this->children) && in_array($name,$this->children))
            )
                continue;
            $array[$name] = $node['title'];
        }
        return $array;
    }

    public function getParentArray()
    {
        $nodes = $this->getFamily();
        $array = [];
        if(is_array($this->parents ))
            foreach($this->parents as $name){
                if(empty($nodes[$name])) continue;
                $array[$name] = $nodes[$name]['title'];
            }
        return $array;
    }

    public function getChildrenArray()
    {
        $nodes = $this->getFamily();
        $array = [];
        if(is_array($this->children ))
            foreach($this->children as $name){
                $array[$name] = $nodes[$name]['title'];
            }
        return $array;
    }

    public static function getModuleArray()
    {
        $items =  self::find()->where([
            'type'=>self::TYPE_PERMISSION,
            'category'=>'module',
        ])->asArray()->all(self::getDb());
        $modules = [];
        foreach($items as $item){
            $modules[$item['name']] = $item['title'];
        }
        return $modules;
    }

    public static function instancePermission()
    {
        return new Node(['type'=>self::TYPE_PERMISSION]);
    }

    public static function instanceRole()
    {
        return new Node(['type'=>self::TYPE_ROLE,'category'=>'role','belong_to'=>'role']);
    }

    /**
     * 删除某个节点的指定类型的第一代子节点
     * @param $type
     * @param $name
     * @return int
     */
    public static function deleteFirstGenerationChildrenFromNode($type,$name){
        return self::getDb()
            ->createCommand('
              DELETE nc FROM  '.ItemChild::tableName().' as nc,'.self::tableName().' as n 
              WHERE nc.parent=:parent AND n.type=:type
              AND nc.child = n.name')
            ->bindParam(':type',$type)
            ->bindParam(':parent',$name)
            ->execute();
    }

    /**
     * 删除某个节点的指定类型的父节点
     * @param $type
     * @param $name
     * @return int
     */
    public static function deleteFirstGenerationParentsFromNode($type,$name){
        return self::getDb()
            ->createCommand("
              DELETE nc FROM  ".ItemChild::tableName()." as nc,".self::tableName()." as n 
              WHERE nc.child=:child AND n.type=:type
              AND nc.parent = n.name")
            ->bindParam(':type',$type)
            ->bindParam(':child',$name)
            ->execute();
    }

    /**
     * 给某个节点添加子节点
     * @param $childrenNames
     * @param $name
     * @return int
     */
    public static function addFirstGenerationChildrenToNode($childrenNames,$name){
        $data = [];
        foreach($childrenNames as $child) {
            $data[] = [$name,$child];
        }
        return self::getDb()
            ->createCommand()
            ->batchInsert(ItemChild::tableName(), ['parent', 'child'], $data)
            ->execute();
    }

    /**
     * 查找节点的所有子节点
     * 递归查找的深度最大值为1000
     * 避免出现死循环
     * 本表结构的设计有死循环的可能性
     * @param $node
     * @param $links
     * @param array $children
     * @param int $type
     * @param int $dep
     */
    public static function findRelationBetweenNodeWithChildrenByType($node,&$links,&$children=[],$type=1,$dep=0) {
        $nodes = self::getNodes();
        $rootNode = $nodes[$node];
        $map = self::getChildrenMap();
        if($dep == 1000) return;
        $dep++;
        if (isset($map[$node])) {
            foreach($map[$node] as $child){
                if(isset($nodes[$child]) && $nodes[$child]['type']==$type) {
                    $children[$child]=$nodes[$child];
                    $links[]=['parent'=>$rootNode,'child'=>$nodes[$child]];
                    self::findRelationBetweenNodeWithChildrenByType($child,$links,$children,$type,$dep);
                }
            }
        }
    }

    public static function getRolesOfUser($userId)
    {
        $roles = (new Query())
            ->from(Assignment::tableName())
            ->where(['user_id'=>$userId])
            ->all(self::getDb());
        $names=[];
        foreach($roles as $node) {
            $names[]=$node['item_name'];
        }
        return $names;
    }

    /**
     * 寻找某个角色下的所有的routes（nodeCategory=action)
     * @param $role
     * @return array
     */
    public static function findAllRoutesOfRole($role)
    {

        $nodes = self::getNodes();
        self::findChildren($role,$children);
        $routes = [];
        foreach(array_keys($children) as $child){
            if($nodes[$child]['category']=='action'){
                $routes[$child]=true;
            }
        }
        return $routes;
    }

    public static function getRoutesOfUser($userId) {
        $roles = self::getRolesOfUser($userId);
        $routes = [];
        foreach($roles as $role){
            $routes = array_merge($routes,self::findAllRoutesOfRole($role));
        }
        return $routes;
    }

}