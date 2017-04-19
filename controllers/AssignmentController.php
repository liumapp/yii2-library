<?php

namespace liumapp\library\controllers;

use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use liumapp\library\models\Admin;
use liumapp\library\models\Organization;
use liumapp\library\models\AdminOrganization;

/**
 * AdminOrganizationController implements the CRUD actions for AdminOrganization model.
 */
class AssignmentController extends Controller
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

    public function actions()
    {
        return [
            'chooser'=>[
                'class'=>'liumapp\library\widgets\ChooserAction'
            ]
        ];
    }

    /**
     * Lists all AdminOrganization models.
     * @param $id integer
     * @return string
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionIndex($id)
    {
        if ($post = Yii::$app->request->post()){
            if (is_array($post['organizationId'])) {
                $models = [];
                foreach($post['organizationId'] as $organizationId) {
                    $models[]=[
                        'adminId'=>$id,
                        'organizationId'=>$organizationId
                    ];
                }
                $db = Yii::$app->getDb();
                // start transaction
                $transaction = $db->beginTransaction();
                try {
                    //remove old settings
                    AdminOrganization::deleteAll(['adminId'=>$id]);
                    $command = $db->createCommand();
                    //add new settings
                    $command->batchInsert(AdminOrganization::tableName(),['adminId','organizationId'],$models);
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
            $adminOrganizations = AdminOrganization::find()->where(['adminId'=>$id])->asArray()->all();

            // organizationIds of a admin
            $organizationIds = ArrayHelper::getColumn($adminOrganizations,'organizationId');
            $dataProvider = new ActiveDataProvider([
                'query' => Organization::find(),
            ]);
            return $this->render('index',[
                'dataProvider'=>$dataProvider,
                'hasOrganizationIds'=>$organizationIds,
                'admin'=>Admin::findOne(['id'=>$id])
            ]);
        }
    }
    
}
