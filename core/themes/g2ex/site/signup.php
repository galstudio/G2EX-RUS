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
    $this->title ='创建帐号并绑定第三方帐号'.$this->title ;
    $btnLabel = '创建帐号并绑定';
} else {
    $this->title = Html::encode($settings['site_name']).' › 注册'  ;
    $btnLabel = '注册';
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?php if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) : ?>
<div class="sep20"></div>
<div class="box">
<div class="header">其他登录方式</div>
<div class="cell" style="text-align: center;">
<?=\yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'],'popupMode' => false, ]);?>
</div>
</div>
<?php endif; ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box" style="overflow: hidden;">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 注册</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<?php if ($model->action === SignupForm::ACTION_AUTH_SIGNUP) : ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
<td width="120" align="right">&nbsp;</td>
<td width="auto" align="left">&nbsp;&nbsp;您已通过<?=$authInfo['sourceName']; ?>登录<div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">用户名<div class="sep10"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=$authInfo['username']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">已有本站帐号？<div class="sep20"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=Html::a('绑定已有帐号', ['auth-bind-account'], ['class'=>'super normal button']); ?><div class="sep20"></div></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2" style="padding: 10px 130px;font-size: 16px;border-top: #e2e2e2 1px solid;"><strong>创建本站账号</strong></td>
</tr>
</tbody></table>
<?php endif; ?>
<?=$form->field($model, 'username')->textInput(['maxlength'=>20,'class'=>'sl']); ?><span class="fade">请使用半角的 a-z 或数字 0-9</span>
<?=$form->field($model, 'password')->passwordInput(['maxlength'=>20,'class'=>'sl']); ?>
<?=$form->field($model, 'password_repeat')->passwordInput(['maxlength'=>20,'class'=>'sl']); ?>
<?=$form->field($model, 'email')->textInput(['maxlength'=>50,'class'=>'sl']); ?><span class="fade">请使用真实电子邮箱注册，我们不会将你的邮箱地址分享给任何人</span>
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
