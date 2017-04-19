<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <?php
            use \liumapp\library\components\OSS;
            $session = Yii::$app->session;
            $photo = $session->get('photo');
            ?>
            <div class="pull-left image">
                <?= \yii\helpers\Html::img($photo?OSS::getAvatar($photo):$directoryAsset.'/img/user2-160x160.jpg',
                    ['class'=>'img-circle','height'=>160,'width'=>160,'alt'=>"User Image"]) ?>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->session->get('userName')?></p>
                <?= \yii\bootstrap\Html::a('<i class="fa fa-circle text-success"></i> 在线',['site/profile'])?>
            </div>
        </div>

        <?php
        $menus = \liumapp\library\models\Menu::getMenus(Yii::$app->user->id,array_keys($session->get('roles',[])));
        $items = \liumapp\library\helpers\ModelHelper::listToTree($menus);
        ?>
        <?= \liumapp\library\widgets\adminlte\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $items,
            ]
        ) ?>

    </section>

</aside>
