<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\SignupForm;
$settings = Yii::$app->params['settings'];
if ($model->action === SignupForm::ACTION_AUTH_SIGNUP) {
    $this->title ='Создание учетной записи с помощью сторонней'.$this->title ;
    $btnLabel = 'Создать аккаунт и привязать';
} else {
    $this->title = Html::encode($settings['site_name']).' › Регистрация'  ;
    $btnLabel = 'Регистрация';
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?php if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) : ?>
<div class="sep20"></div>
<div class="box">
<div class="header">Другие способы входа</div>
<div class="cell" style="text-align: center;">
<?=\yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'],'popupMode' => false, ]);?>
</div>
</div>
<?php endif; ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box" style="overflow: hidden;">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Регистрация</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<?php if ($model->action === SignupForm::ACTION_AUTH_SIGNUP) : ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
<td width="120" align="right">&nbsp;</td>
<td width="auto" align="left">&nbsp;&nbsp;Вы вошли через <?=$authInfo['sourceName']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">Логин<div class="sep10"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=$authInfo['username']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">У вас уже есть аккаунт? <div class="sep20"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=Html::a('Привязать существующий аккаунт', ['auth-bind-account'], ['class'=>'super normal button']); ?><div class="sep20"></div></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2" style="padding: 10px 130px;font-size: 16px;border-top: #e2e2e2 1px solid;"><strong>Создать аккаунт на сайте</strong></td>
</tr>
</tbody></table>
<?php endif; ?>
<?=$form->field($model, 'username')->textInput(['maxlength'=>20,'class'=>'sl']); ?><span class="fade">используйте буквы (a-z) и/или цифры (0-9)</span>
<?=$form->field($model, 'password')->passwordInput(['maxlength'=>20,'class'=>'sl']); ?>
<?=$form->field($model, 'password_repeat')->passwordInput(['maxlength'=>20,'class'=>'sl']); ?>
<?=$form->field($model, 'email')->textInput(['maxlength'=>50,'class'=>'sl']); ?><span class="fade">используйте реальный адрес электронной почты для регистрации</span>
<?php
if ( intval(Yii::$app->params['settings']['close_register']) === 2 ) {
    echo $form->field($model, 'invite_code')->textInput(['maxlength'=>10,'class'=>'sl']);
}
if ( $model->action !== SignupForm::ACTION_AUTH_SIGNUP && intval(Yii::$app->params['settings']['captcha_enabled']) === 1 ) {
    echo $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::classname());
}
?>
<div class="sep5"></div>
<?=Html::submitButton($btnLabel, ['class' => 'super normal button', 'name' => 'signup-button']);?>
 <?php ActiveForm::end(); ?>
    </div>
</div>
