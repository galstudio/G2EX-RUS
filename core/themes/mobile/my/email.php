<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\ChangeEmailForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$title = '更换邮箱';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
$ceModel = new ChangeEmailForm();
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('设置', ['my/settings']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 更换邮箱</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
您还没有激活，请进入注册时填写的邮箱(<?=$me->email; ?>)，点击激活链接。<br /><br />
<?=Html::a('重发激活邮件', ['service/send-activate-mail']); ?>  <?=Html::a('修改邮箱', ['my/email']); ?>
</div>	
<?php endif; ?>
<?php if ( $session->hasFlash('chgEmailNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgEmailNG');?></div>
<?php } else if ( $session->hasFlash('chgEmailOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('chgEmailOK');?></div>
<?php }?>
<div class="cell" id="form">
<?php $form = ActiveForm::begin(['action' => ['service/change-email']]); ?>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
            	<td width="90" align="right">当前邮箱 <div class="sep10"></div></td>
                <td width="auto" align="left">&nbsp;&nbsp;<?=$me->email; ?> <div class="sep10"></div></td>
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
</div>