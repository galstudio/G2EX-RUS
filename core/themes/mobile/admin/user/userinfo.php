<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\User;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
$settings = Yii::$app->params['settings'];
$title ='会员编辑';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$formatter = Yii::$app->getFormatter();
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('会员管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<?php if ( $session->hasFlash('adminProfileNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('adminProfileNG');?></div>
<?php } else if ( $session->hasFlash('adminProfileOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('adminProfileOK');?></div>
<?php }?>
<?php if ( $session->hasFlash('adminPwdNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('adminPwdNG');?></div>
<?php } else if ( $session->hasFlash('adminPwdOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('adminPwdOK');?></div>
<?php }?>
<div class="inner form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
    <td width="80" align="right"><div class="sep10"></div>用户名<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div><div class="fr" style="margin: -3px 8px 0px 0px"><?=Html::a('充值', ['admin/user/charge', 'to'=>Html::encode($user['username'])],['class'=>'super normal button']); ?></div>&nbsp;&nbsp;<?=$user->username; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="80" align="right"><div class="sep10"></div>注册时间<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$formatter->asDateTime($user->getUser()->created_at, 'y-MM-dd HH:mm:ss xxx'); ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="80" align="right"><div class="sep10"></div>注册IP<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=long2ip($user->getUser()->userInfo->reg_ip); ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="80" align="right"><div class="sep10"></div>最后登录时间<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$formatter->asDateTime($user->getUser()->userInfo->last_login_at, 'y-MM-dd HH:mm:ss xxx'); ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="80" align="right"><div class="sep10"></div>最后登录IP<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=long2ip($user->getUser()->userInfo->last_login_ip); ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field($user, "email")->textInput(['maxlength'=>50]); ?></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field($user, "status")->dropDownList(User::$statusOptions); ?></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field($user, "role")->dropDownList(User::$roleOptions); ?></td>
</tr>
<tr>
<td width="100" align="right">&nbsp;&nbsp;</td>
<td width="auto" align="left" colspan="2">&nbsp;&nbsp;<?=Html::submitButton('更改信息', ['class' => 'super normal button']); ?></td>
</tr>
</tbody></table>
<?php ActiveForm::end();?>
<?php $form = ActiveForm::begin(['action' => ['admin/user/reset-password', 'id'=>$user->id],'id' => 'form-setting',]); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field($user, "password")->textInput(['maxlength'=>20]); ?></td>
</tr>
<tr>
<td width="100" align="right">&nbsp;&nbsp;</td>
<td width="auto" align="left" colspan="2">&nbsp;&nbsp;<?=Html::submitButton('更改密码', ['class' => 'super normal button']); ?></td>
</tr>
</tbody></table>
<?php ActiveForm::end();?>
<div class="sep10"></div>
</div>
</div>
</div>