<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\ChangePasswordForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$title = '修改密码';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
$cpModel = new ChangePasswordForm();
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('设置', ['my/settings']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 修改密码</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
您还没有激活，请进入注册时填写的邮箱(<?=$me->email; ?>)，点击激活链接。<br /><br />
<?=Html::a('重发激活邮件', ['service/send-activate-mail']); ?>  <?=Html::a('修改邮箱', ['service/email']); ?>
</div>  
<?php endif; ?>
<?php if ( $session->hasFlash('chgPwdNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdNG');?></div>
<?php } else if ( $session->hasFlash('chgPwdOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgPwdOK');?></div>
<?php }?>
<div class="cell" id="form">
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
</div>
