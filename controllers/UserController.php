<?php

namespace liumapp\library\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use liumapp\library\models\Menu;
use liumapp\library\models\Admin;
use liumapp\library\models\AdminSearch;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'roles'=>['admin'],
                        'allow' => true,
                    ]
                ],
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
     * Lists all Admin models.
     * @return mixed
     */
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
     * Displays a single Admin model.
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
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $formName = $model->formName();
            $data = Yii::$app->request->post();
            if (!empty($data[$formName]['password'])) {
                $model->setPassword($data[$formName]['password']);
                $model->generateAuthKey();
            }
            unset($data[$formName]['password']);
            if ($model->load($data) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->password = null;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 设置快捷菜单
     * @return string
     */
    public function actionShortcut()
    {
        /**
         * @var \liumapp\library\models\Admin
         */
        $admin = Admin::findOne(\Yii::$app->user->id);

        if ($post = Yii::$app->request->post()){
            $menus = Menu::find()->where(['in','id',$post['id']])->asArray()->all();
            $admin->shortcutMenu = Json::encode($menus);
            $admin->save();

        }
        $shortcutMenu = $admin->shortcutMenu ? Json::decode($admin->shortcutMenu):[];
        $roles = Yii::$app->session->get('roles');

        $dataProvider = new ActiveDataProvider([
            'query' =>Menu::findMenus($admin->id,$roles),
            'pagination'=>false
        ]);
        return $this->render('shortcut',[
            'dataProvider'=>$dataProvider,
            'hasMenuIds'=>ArrayHelper::getColumn($shortcutMenu,'id')
        ]);

    }
    

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->isDel = 1;
        $model->save(false);

        return $this->redirect(['index']);
    }


    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
