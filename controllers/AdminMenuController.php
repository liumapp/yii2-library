<?php

namespace liumapp\library\controllers;


use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use liumapp\library\models\Node;
use liumapp\library\models\Menu;
use liumapp\library\models\AdminMenu;


/**
 * AdminMenuController implements the CRUD actions for AdminMenu model.
 */
class AdminMenuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    ['roles'=>['admin'],'allow' => true,]
                ]
            ],
        ];
    }

    /**
     * @param $id integer
     * @return string
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionIndex($id)
    {
        if ($post = Yii::$app->request->post()){
            if (is_array($post['menuId'])) {
                $models = [];
                foreach($post['menuId'] as $menuId) {
                    $models[]=[
                        'roleId'=>$id,
                        'menuId'=>$menuId
                    ];
                }
                $db = Yii::$app->getDb();
                // start transaction
                $transaction = $db->beginTransaction();
                try {
                    //remove old settings
                    AdminMenu::deleteAll(['roleId'=>$id]);
                    $command = $db->createCommand();
                    //add new settings
                    $command->batchInsert(AdminMenu::tableName(),['roleId','menuId'],$models);
                    if ($command->execute()){
                        
                        //commit if success
                        $transaction->commit();
                        return $this->redirect(['index','id'=>$id]);
                    }

                } catch (\Exception $e) {
                    //rollback if raising some error
                    $transaction->rollBack();
                }

                throw new ErrorException('Server Error');
            }
        } else {
            $roleMenus = AdminMenu::find()->where(['roleId'=>$id])->asArray()->all();
            
            // menuIds of a role
            $menuIds = ArrayHelper::getColumn($roleMenus,'menuId');
            $dataProvider = new ActiveDataProvider([
                'query' => Menu::find()->where(['enabled'=>1]),
                'pagination'=>false
            ]);
            return $this->render('index',[
                'dataProvider'=>$dataProvider,
                'hasMenuIds'=>$menuIds,
                'role'=>Node::findOne(['name'=>$id])
            ]);
        }

    }

}
