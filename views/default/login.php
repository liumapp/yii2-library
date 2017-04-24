<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \liumapp\library\models\LoginForm */

$this->title = '登录';

?>
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <?php $form = ActiveForm::begin(['id' => 'login_form' , 'enableClientValidation' => false])?>

                        <h1><?= Yii::$app->name?></h1>

                        <?= $form->field($model , 'userName')->textInput(['placeholder' => 'userName'])->label(false)?>

                        <?= $form->field($model , 'password')->passwordInput(['placeholder' => 'password'])->label(false)?>

                        <?= $form
                            ->field($model, 'verifyCode')
                            ->label(false)
                            ->widget(\liumapp\library\widgets\Captcha::className(),
                                [
                                    'clientOptions'=>[
                                        'submitButton'=>'#submit'
                                    ]
                                ]) ?>

                        <div class="row">
                            <div class="col-xs-8">
                                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <?= Html::submitButton('登录', ['id'=>'submit','class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                            </div>
                            <!-- /.col -->
                        </div>


                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">忘记密码啦?
                                <a href="#signup" class="to_register"> 点我 </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                            </div>
                        </div>
                    <?php ActiveForm::end();?>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                                <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

    </div>
</div>