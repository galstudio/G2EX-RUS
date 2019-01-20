<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\models\UploadForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$title = 'Аватар';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('Настройки', ['my/settings']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Аватар</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
Вы не активировали, указанный при регистрации Email^ (<?=$me->email; ?>)<br /><br />
<?=Html::a('Повторно отправить письмо с кодом активации', ['service/send-activate-mail']); ?>  <?=Html::a('Изменить Email', ['service/email']); ?>
</div>
<?php endif; ?>
<?php if ( $session->hasFlash('setAvatarNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('setAvatarNG');?></div>
<?php } else if ( $session->hasFlash('setAvatarOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('setAvatarOK');?></div>
<?php }?>
<div class="cell" id="form">
<?php $form = ActiveForm::begin(['action' => ['service/avatar'],'options' => ['enctype' => 'multipart/form-data'],]); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody><tr>
    <td width="120" align="right">Текущий&nbsp;</td>
    <td width="auto" align="left">&nbsp;&nbsp;&nbsp;<?=Html::img('@web/'.str_replace('{size}', 'large', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'normal', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'small', $me->avatar)); ?></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><?=$form->field((new UploadForm(Yii::$container->get('avatarUploader'))), 'file')->fileInput(); ?></td>
</tr>
<tr>
<td width="120" align="right"></td>
<td width="auto" align="left"><span class="gray" style="margin-left:10px;">не более 2MB, формат PNG / JPG / GIF</span></td>
</tr>
<tr>
<td width="auto" align="left" colspan="2"><div class="sep10"></div><?=Html::submitButton('Загрузить', ['class' => 'super normal button']); ?></td>
</tr>
</tbody></table>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
