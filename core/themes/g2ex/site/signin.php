<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › Авторизация'  ;
$title = 'Авторизация';
?>
<?=$this->render('@app/views/common/login'); ?>
<?php if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) : ?>
<div class="sep20"></div>
<div class="box">
<div class="header">Другой режим входа</div>
<div class="cell" style="text-align: center;">
<?=\yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'],'popupMode' => false, ]);?>
</div>
</div>
<?php endif; ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Авторизация</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<?=$form->field($model, 'username')->textInput(['maxlength'=>20,'class'=>'sl']); ?>
<?=$form->field($model, 'password')->passwordInput(['maxlength'=>20,'class'=>'sl']); ?>
<?php
if ( intval(Yii::$app->params['settings']['captcha_enabled']) === 1 ) {
	echo $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname());
}
?>
<div class="sep5"></div>
<?=Html::submitButton('Вход', ['class' => 'super normal button', 'name' => 'login-button']);?>
<div class="sep5"></div>
<?=Html::a('Я забыл свой пароль', ['site/forgot-password'],['style'=>'margin-left:130px;']); ?>
<?php ActiveForm::end(); ?>
    </div>
</div>
