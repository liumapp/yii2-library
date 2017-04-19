<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2016/12/28
 * Time: 10:48
 */

namespace liumapp\library\models;


use yii\base\Model;
use yii\db\Query;

/**
 *
 *
 * @property integer $userId
 * @property array $items
 * @property string $createdAt
 */
class AssignForm extends Model
{

    /**
     * @var integer
     */
    public $userId;

    /**
     * @var array
     */
    public $items=[];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'items'], 'required'],
            [['userId'], 'integer'],
            [['items'], 'each','rule'=>['string', 'max' => 63]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adminId' => \Yii::t('app', 'Admin ID'),
            'nodeNames' => \Yii::t('app', 'Node Names'),
        ];
    }

    public function save($validate=true)
    {
        if($validate && $this->validate()) {

            Assignment::getDb()
                ->createCommand()
                ->delete(Assignment::tableName(),['user_id'=>$this->userId])
                ->execute();

            $assignments = [];
            foreach($this->items as $name){
                $assignments[]=[
                    $this->userId,$name,date('Y-m-d H:i:s')
                ];
            }
            Assignment::getDb()
                ->createCommand()
                ->batchInsert(Assignment::tableName(), ['user_id', 'item_name','created_at'], $assignments)
                ->execute();

            return true;
        }
        return false;
    }

    /**
     * @param integer $userId
     * @return array|mixed
     */
    public static function findAssignedNodes($userId)
    {
        return self::getRolesOfUser($userId);
    }

    public static function getRolesOfUser($userId)
    {
        $roles = (new Query())
            ->from(Assignment::tableName())
            ->where(['user_id'=>$userId])
            ->all(Assignment::getDb());
        $names=[];
        foreach($roles as $node) {
            $names[]=$node['item_name'];
        }
        return $names;
    }
}