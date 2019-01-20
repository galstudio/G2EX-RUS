<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$this->title = $this->title . ' › 绑定本站帐号';
$title = '绑定本站帐号';
?>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 绑定本站帐号</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
<td width="100" align="right">&nbsp;</td>
<td width="auto" align="left">&nbsp;&nbsp;您已通过<?=$authInfo['sourceName']; ?>登录<div class="sep10"></div></td>
</tr>
<tr>
<td width="100" align="right">用户名<div class="sep10"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=$authInfo['username']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="100" align="right">还没本站帐号？<div class="sep20"></div></td>
<td width="auto" align="left">&nbsp;&nbsp;<?=Html::a('创建本站帐号并绑定', ['auth-signup'], ['class'=>'super normal button']); ?><div class="sep20"></div></td>
</tr>
<tr>            
<td width="auto" align="center" colspan="2" style="padding: 10px 0px;font-size: 16px;border-top: #e2e2e2 1px solid;"><strong>绑定本站账号</strong></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field($model, 'username')->textInput(['maxlength'=>20]); ?></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"> <?=$form->field($model, 'password')->passwordInput(['maxlength'=>20]); ?></td>
</tr>  
</tbody></table>
<div class="sep5"></div>
<?=Html::submitButton('绑定', ['class' => 'super normal button','style'=>'width:100px;', 'name' => 'login-button']);?>
<div class="sep5"></div>
<?php ActiveForm::end(); ?>
</div>
<?php if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) : ?>
<div class="sep5"></div>
<div class="box">
<div class="header">其他登录方式</div>
<div class="cell" style="text-align: center;">
<?=\yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'],'popupMode' => false, ]);?>
</div>
</div>
<?php endif; ?>