<?php
namespace liumapp\library\controllers;


use liumapp\library\models\AssignForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use liumapp\library\models\AdminSearch;

class RbacDefaultController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        //只查询没有删除的数据
        $searchModel->isDel = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @param $title
     * @return string
     */
    public function actionRoles($id,$title)
    {
        $model = new AssignForm();
        $model->userId = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['roles', 'id' =>$id,'title'=>$title]);
        } else {
            $model->items = AssignForm::findAssignedNodes($id);
            return $this->render('roles', [
                'model' => $model,
                'title'=>$title
            ]);
        }
    }
}