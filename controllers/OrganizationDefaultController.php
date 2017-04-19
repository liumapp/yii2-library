<?php

namespace liumapp\library\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use huluwa\common\helpers\ModelHelper;
use liumapp\library\models\Organization;
use liumapp\library\models\OrganizationSearch;

/**
 * OrganizationController implements the CRUD actions for Organization model.
 */
class DefaultController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Organization models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }

    /**
     * Displays a single Organization model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organization();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->pid == 0){
                $model->level = 0;
            }else{
                $parentModel = $this->findModel($model->pid);
                $model->level = $parentModel->level+1;
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->pid = Yii::$app->request->get('id',0);
            return $this->render('create', [
                'parents'=>$this->getParents(),
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'parents'=>$this->getParents()
            ]);
        }
    }

    /**
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return array
     */
    protected function getParents() {
        $models = Organization::find()->where(['isDel'=>0])->asArray()->all();
        $treeModels = ModelHelper::subTree($models,0,1,'id','pid');
        $items[] = '不选择';
        foreach($treeModels as $model) {
            $items[$model['id']]=str_repeat('|----',$model['level']) . $model['name'];
        }
        return $items;
    }
}
