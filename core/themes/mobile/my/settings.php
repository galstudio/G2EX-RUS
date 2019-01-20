<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\authclient\Collection;
use app\models\UserInfo;
use app\models\UploadForm;
use app\models\ChangePasswordForm;
use app\models\ChangeEmailForm;
use app\models\Auth;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
$myInfo = $me->userInfo;
$cpModel = new ChangePasswordForm();
$ceModel = new ChangeEmailForm();
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › 设置';
$title = '设置';
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 设置</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
您还没有激活，请进入注册时填写的邮箱(<?=$me->email; ?>)，点击激活链接。<br /><br />
<?=Html::a('重发激活邮件', ['service/send-activate-mail']); ?>  <?=Html::a('修改邮箱', ['my/email']); ?>
</div>	
<?php endif; ?>
<?php if ( $session->hasFlash('EditProfileNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditProfileNG');?></div>
<?php } else if ( $session->hasFlash('EditProfileOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditProfileOK');?></div>
<?php }?>
<div class="inner">
<?php $form = ActiveForm::begin(['action' => ['service/edit-profile'],'id' => 'form']); ?>
<table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="auto" align="left" colspan="2">
                <div class="form-group field-userinfo-website">
                <label class="control-label">用户名</label>
                <div class="sep5"></div>
                <?=$me->username; ?>
                </div></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2">
                <div class="form-group field-userinfo-website">
                <label class="control-label">状态</label>
                <div class="sep5"></div>
                <?=$me->getStatus(); ?>
                </div></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'website')->textInput(['maxlength'=>100]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'location')->textInput(['maxlength'=>100]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'tagline')->textInput(['maxlength'=>100]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'qq')->textInput(['maxlength'=>15]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'about')->textArea(['maxlength'=>255]); ?></td>
            </tr>
             <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'mynodes')->dropdownList(['0'=>'显示','1'=>'不显示']);?></td>
            </tr>
             <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'top_close')->dropdownList(['0'=>'参与','1'=>'不参与']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'css_close')->dropdownList(['0'=>'使用','1'=>'不使用']);?></td>
            </tr>
             <tr>
             
                <td width="auto" align="left" colspan="2" class="mycss"><label class="control-label">自定义CSS<br><a href="/t/20" target="_blank">参考CSS</a></label><?=$form->field($me->userInfo, 'mycss')->textArea(['maxlength'=>10000]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('保存设置', ['class' => 'super normal button']); ?></td>
            </tr>
</tbody></table>
<?php ActiveForm::end(); ?>
</div></div>
<div class="sep5"></div>
<div class="box">
    <div class="cell">头像上传</div>
    <div class="cell">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="80" align="right">当前头像</td>
                <td width="auto" align="left"><?=Html::img('@web/'.str_replace('{size}', 'large', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'normal', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'small', $me->avatar)); ?></td>
            </tr>
            <tr>
                <td width="80" align="right"></td>
                <td width="auto" align="left"><div class="sep5"></div><?=Html::a('上传新头像', ['my/avatars'], ['class' => 'super normal button']);?></td>
            </tr>
        </tbody></table>
    </div>
    <div class="inner">
    关于头像的规则
    <ul>
        <li><?=Html::encode($settings['site_name']);?> 禁止使用任何低俗或者敏感图片作为头像</li>
        <li>如果你是男的，请不要用女人的照片作为头像，这样可能会对其他会员产生误导</li>
    </ul>
    </div>
</div>
<div class="sep5"></div>
<div class="box">
    <div class="cell"><div class="fr"><span class="fade">如果你不打算更换邮箱，请留空以下区域</span></div>更换邮箱</div>
<?php if ( $session->hasFlash('chgEmailNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgEmailNG');?></div>
<?php } else if ( $session->hasFlash('chgEmailOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgEmailOK');?></div>
<?php }?>
    <div  id="form">
<?php $form = ActiveForm::begin(['action' => ['service/change-email']]); ?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
                <td width="auto" align="left" colspan="2"><div class="sep5"></div>
                <div class="form-group field-userinfo-website">
                <label class="control-label">当前邮箱</label>
                <?=$me->email; ?>
                </div><div class="sep5"></div></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($ceModel, 'email')->textInput(['maxlength'=>50]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($ceModel, 'password')->passwordInput(['maxlength'=>20]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('更换邮箱', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>
</div>
<div class="sep5"></div>
<div class="box">
    <div class="cell"><div class="fr"><span class="fade">如果你不打算更改密码，请留空以下区域</span></div>更改密码</div>
<?php if ( $session->hasFlash('chgPwdNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdNG');?></div>
<?php } else if ( $session->hasFlash('chgPwdOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdOK');?></div>
<?php }?>
<div  id="form">
<?php $form = ActiveForm::begin(['action' => ['service/change-password']]); ?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($cpModel, 'old_password')->passwordInput(['maxlength'=>20]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($cpModel, 'password')->passwordInput(['maxlength'=>20]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($cpModel, 'password_repeat')->passwordInput(['maxlength'=>20]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('更改密码', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>
</div>
<?php
if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) {?>
<div class="sep5"></div>
<div class="box">
    <div class="cell">绑定第三方帐号</div>
<?php if ( $session->hasFlash('chgPwdNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdNG');?></div>
<?php } else if ( $session->hasFlash('chgPwdOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdOK');?></div>
<?php }?>
<div id="form">
<?php
$auths = ArrayHelper::getColumn($me->auths, 'source');
$authed = $unauthed = [];
foreach (Yii::$app->authClientCollection->getClients() as $client){
	if( in_array($client->getId(), $auths) ) {
		$authed[] = Html::a('<i class="iconfont icon-'.$client->getId().'"></i>&nbsp;&nbsp;<i class="auth-title">'. Html::encode($client->getTitle()) . '</i>', ['service/unbind-account', 'source'=>$client->getId()], ['class'=>'auth-link '. $client->getId(), 'title'=>'解绑']);
	} else {
		$unauthed[] = Html::a('<i class="iconfont icon-'.$client->getId().'"></i>&nbsp;&nbsp;<i class="auth-title">'. Html::encode($client->getTitle()) . '</i>', ['site/auth', 'authclient'=>$client->getId(), 'action'=>'bind'], ['class'=>'auth-link '. $client->getId(), 'title'=>'绑定']);
	}
}
?>
 <div class="cell">
 已绑定&nbsp;&nbsp;<?=implode('&nbsp;&nbsp;&nbsp;&nbsp;', $authed); ?>
 </div>
  <div class="inner">
 未绑定&nbsp;&nbsp;<?=implode('&nbsp;&nbsp;&nbsp;&nbsp;', $unauthed); ?>
 </div>
</div>
<?php }?>
</div>
<div class="sep5"></div>
<div class="box">
<div class="cell">隐私设置</div>
<div class="inner">
    <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tbody>
        <tr>
            <td width="60" align="right"><span class="gray">邮箱</span></td>
            <td width="auto" align="left"><?php if($myInfo->email_close == 0){echo '显示';}else{echo '隐藏';};?></td>
        </tr>
        <tr>
            <td width="60" align="right"><span class="gray">主题列表</span></td>
            <td width="auto" align="left"><?php if($myInfo->topic_close == 0){echo '显示';}else{echo '隐藏';};?></td>
        </tr>
        <tr>
            <td width="60" align="right"><span class="gray">回复列表</span></td>
            <td width="auto" align="left"><?php if($myInfo->comment_close == 0){echo '显示';}else{echo '隐藏';};?></td>
        </tr>
        <tr>
            <td width="60" align="right"></td>
            <td width="auto" align="left"><input type="button" class="super normal button" value="打开隐私设置" onclick="location.href = '/settings/privacy';"></td>
        </tr>
    </tbody></table>
</div>
</div>
</div>
