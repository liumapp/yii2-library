<?php

namespace liumapp\library\controllers;


use liumapp\library\models\ItemSearch;
use liumapp\library\models\Node;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use liumapp\library\models\Item;

/**
 * RolesController implements the CRUD actions for Role model.
 */
class RolesController extends Controller
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch(['type'=>\yii\rbac\Item::TYPE_ROLE]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Role model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Node::instanceRole();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }/* @var $module \liumapp\library\Module */
        $module = $this->module;
        $model->parents = [$module->defaultRoleParent];
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Copies a new Item model.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionCopy($id)
    {
        if (\Yii::$app->request->isGet) {
            $model = $this->findModel($id);
            $model->isNewRecord = true;
        } else {
            $model = Node::instanceRole();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    public function actionPermission($id)
    {
        if ($post = Yii::$app->request->post()){
            if (is_array($post['name'])){
                Node::deleteFirstGenerationChildrenFromNode(Node::TYPE_PERMISSION,$id);
                Node::addFirstGenerationChildrenToNode($post['name'],$id);
            }
            return $this->redirect(['permission','id'=>$id]);

        } else {
            $nodes = Node::getNodes();
            $modules = [];
            foreach ($nodes as $name => $node) {
                //$links = [];
                //$children = [];
                if ($node['type'] == Node::TYPE_PERMISSION && $node['category'] == 'module') {
                    //RBACHelper::findRelationBetweenNodeWithChildrenByType($node['name'], $links, $children, 'permission');
                    $family = Node::findFamily($node['belong_to'],$nodes);
                    $modules[] = [
                        'node' => $node,
                        'links' => Node::findFamilyLinks($family),
                        'family' => $family
                    ];
                }
            }
            $roleFirstGenerationPermissions = Node::getFirstGenerationChildren($id, Node::TYPE_PERMISSION);
            Node::findChildren($id, $roleAllChildren);
            $roleAllPermission = Node::filterNamesByType($roleAllChildren, Node::TYPE_PERMISSION);
            $roleAfterFirstGenerationPermission = array_diff($roleAllPermission, $roleFirstGenerationPermissions);
            return $this->render('assign-permission2', [
                'modules' => $modules,
                'role' => $nodes[$id],
                'roleFirstGenerationPermissions' => $roleFirstGenerationPermissions,
                'roleAfterFirstGenerationPermission' => $roleAfterFirstGenerationPermission,
            ]);
        }
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Node::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
