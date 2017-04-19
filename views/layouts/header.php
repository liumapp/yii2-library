<?php
use liumapp\library\components\OSS;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
$organizations = $session->get('organizations', []);
$photo = $session->get('photo');
$menus = \liumapp\library\models\Menu::getMenus(Yii::$app->user->id, array_keys($session->get('roles', [])));
$menus1 = array_map(function ($item) {
    $item['url'] = \yii\helpers\Url::toRoute($item['url']);
    $item['label'] = '<i class="' . $item['icon'] . '"></i> ' . $item['label'];
    $item['encode'] = false;
    return $item;
}, $menus);
$items = \liumapp\library\helpers\ModelHelper::listToTree($menus1);
$activeMenuIds = \liumapp\library\models\Menu::findActiveMenus($menus);
$subMenus = [];
foreach ($items as &$item):
    //找到激活的菜单
    $active = '';
    if (in_array($item['id'], $activeMenuIds)) {
        if (isset($item['items']))
            $subMenus = $item['items'];
        $item['options'] = ['class' => 'active'];
    }
endforeach;
?>

<header class="main-header">
    <?php
    NavBar::begin(['brandLabel' => 'HuluwaCRM']);
    echo Nav::widget([
        'items' => $items,
        'options' => ['class' => 'navbar-nav'],
        'dropDownCaret' => ''
    ]);
    ?>
    <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">

            <?= \huluwa\notification\widgets\NotificationWidget::widget() ?>

            <!-- User Account: style can be found in dropdown.less -->

            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                       <span class="">
                           <i class="fa fa-user-circle-o"></i>
                           <?= $session->get('userName') ?>
                       </span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <i class="fa fa-user-circle-o fa-2x" style="color: white"></i>
                        <p>
                            <?= $session->get('userName') ?>
                        </p>
                    </li>
                    <li class="user-body">
                        <?php
                        foreach ($organizations as $organization):
                            ?>
                            <p>
                                <small>
                                    <?= implode('/', \yii\helpers\ArrayHelper::getColumn($organization, 'name')) ?>
                                </small>
                            </p>
                        <?php endforeach; ?>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <?= Html::a(
                                '用户信息',
                                ['/admin/default/profile'],
                                ['class' => 'btn btn-success ']
                            ) ?>
                        </div>
                        <div class="pull-right">
                            <?= Html::a(
                                '退出',
                                ['/admin/default/logout'],
                                ['data-method' => 'post', 'class' => 'btn btn-danger']
                            ) ?>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <?php
    NavBar::end();
    ?>

    <div class="sub-menu">
        <?php foreach ($subMenus as $menu): ?>
            <?= Html::a($menu['label'], $menu['url'], [
                'class' => in_array($menu['id'], $activeMenuIds) ? "active" : ""
            ]) ?>
        <?php endforeach; ?>
    </div>
</header>
