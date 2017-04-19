<?php
namespace liumapp\library\controllers;

use liumapp\library\models\AdminOrganization;
use liumapp\library\models\Organization;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use liumapp\library\models\Admin;
use liumapp\library\models\LoginForm;
use liumapp\library\models\ProfileForm;

/**
 * Default controller
 */
class DefaultController extends Controller
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
                        'actions' => ['login', 'error', 'captcha'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],

            'team' => [
                'class' => 'liumapp\library\widgets\ScopeChooserAction',
            ],
        ];
    }

    /**
     * 首页
     * @return string
     */
    public function actionIndex()
    {
        $admin = Admin::findOne(Yii::$app->user->id);
        $shortcuts = [];
        if ($admin->shortcutMenu) {
            $shortcuts = Json::decode($admin->shortcutMenu);
        }
        return $this->render('index', [
            'shortcuts' => $shortcuts
        ]);
    }

    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * 更新
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $admin = Admin::findOne(['id' => Yii::$app->user->id]);
        //部门信息
        $orgs = (new Query())
            ->select('adminId,org.id,org.name')
            ->from(['ao' => AdminOrganization::tableName()])
            ->leftJoin(['org' => Organization::tableName()],
                'org.id=ao.organizationId')
            ->where(['adminId' => Yii::$app->user->id])
            ->all();
        $profile = new ProfileForm(['admin' => $admin]);
        if ($profile->load($post = Yii::$app->request->post()) && $profile->save()) {
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile', [
                'orgs' => $orgs,
                'model' => $profile->loadData(),
            ]);
        }
    }


}
