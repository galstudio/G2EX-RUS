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
$this->title = Html::encode($settings['site_name']).' › Настройки';
$title = 'Настройки';
?>
<?=$this->render('@app/views/common/login'); ?>
<div class="sep20"></div>
<div class="box">
    <div class="cell">Мои настройки конфиденциальности</div>
    <div class="inner">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
                <td width="60" align="right"><span class="gray">Мой Email</span></td>
                <td width="auto" align="left"><?php if($myInfo->email_close == 0){echo 'не скрывать';}else{echo 'скрывать';};?></td>
            </tr>
            <tr>
                <td width="60" align="right"><span class="gray">Топики</span></td>
                <td width="auto" align="left"><?php if($myInfo->topic_close == 0){echo 'не скрывать';}else{echo 'скрывать';};?></td>
            </tr>
            <tr>
                <td width="60" align="right"><span class="gray">Комментарии</span></td>
                <td width="auto" align="left"><?php if($myInfo->comment_close == 0){echo 'не скрывать';}else{echo 'скрывать';};?></td>
            </tr>
            <tr>
                <td width="60" align="right"></td>
                <td width="auto" align="left"><input type="button" class="super normal button" value="Изменить" onclick="location.href = '/settings/privacy';"></td>
            </tr>
        </tbody></table>
    </div>
</div>

</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Настройки</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
Вы не активировали, указанный при регистрации Email: (<?=$me->email; ?>)<br /><br />
<?=Html::a('Повторно отправить письмо с кодом активации', ['service/send-activate-mail']); ?> | <?=Html::a('Изменить Email', ['my/email']); ?>
</div>
<?php endif; ?>
<?php if ( $session->hasFlash('EditProfileNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditProfileNG');?></div>
<?php } else if ( $session->hasFlash('EditProfileOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditProfileOK');?></div>
<?php }?>
<div class="inner">
<?php $form = ActiveForm::begin(['action' => ['service/edit-profile'],'id' => 'form']); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="120" align="right">Логин:</td>
                <td width="auto" align="left">&nbsp;&nbsp;<?=$me->username; ?></td>
            </tr>
            <tr>
                <td width="120" align="right"> <div class="sep10"></div>Статус:</td>
                <td width="auto" align="left"> <div class="sep10"></div>&nbsp;&nbsp;<?=$me->getStatus(); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'website')->textInput(['maxlength'=>100,'class'=>'sl']); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'location')->textInput(['maxlength'=>100,'class'=>'sl']); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'tagline')->textInput(['maxlength'=>100,'class'=>'sl']); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'qq')->textInput(['maxlength'=>25,'class'=>'sl']); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'about')->textArea(['maxlength'=>255,'class'=>'sl']); ?></td>
            </tr>
             <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'mynodes')->dropdownList(['0'=>'показывать','1'=>'не показывать ']);?></td>
            </tr>
             <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'top_close')->dropdownList(['0'=>'участвовать','1'=>'не участвовать']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'css_close')->dropdownList(['0'=>'использовать','1'=>'не использовать']);?></td>
            </tr>
             <tr>
             <td width="120" align="right">Мой  CSS <br><a href="/go/theme" target="_blank">ссылка CSS</a></td>
                <td width="auto" align="left" colspan="2" class="mycss"><?=$form->field($me->userInfo, 'mycss')->textArea(['maxlength'=>10000,'class'=>'ml','style'=>'margin-left:10px']); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('Сохранить', ['class' => 'super normal button']); ?></td>
            </tr>
</tbody></table>
<?php ActiveForm::end(); ?>
</div></div>
<div class="sep20"></div>
<div class="box">
    <div class="cell">Аватар</div>
    <div class="cell">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="120" align="right">Текущий</td>
                <td width="auto" align="left"><?=Html::img('@web/'.str_replace('{size}', 'large', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'normal', $me->avatar)), ' &nbsp; ', Html::img('@web/'.str_replace('{size}', 'small', $me->avatar)); ?></td>
            </tr>
            <tr>
                <td width="120" align="right"></td>
                <td width="auto" align="left"><div class="sep5"></div><?=Html::a('Изменить', ['my/avatars'], ['class' => 'super normal button']);?></td>
            </tr>
        </tbody></table>
    </div>
    <div class="inner">
    Правила:
    <ul>
        <li>На <?=Html::encode($settings['site_name']);?> ЗАПРЕЩАЕТСЯ использовать вульгарные или непристойные изображения в качестве аватара</li>
        <li>Если вы мужчина, не используйте фотографию женщины в качестве аватара, это может ввести в заблуждение других пользователей</li>
    </ul>
    </div>
</div>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><div class="fr"><span class="fade">если не изменяете, то оставьте поля пустыми</span></div>Изменение Email</div>
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
                <td width="120" align="right">Текущий Email: <div class="sep10"></div></td>
                <td width="auto" align="left">&nbsp;&nbsp;<?=$me->email; ?> <div class="sep10"></div></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($ceModel, 'email')->textInput(['maxlength'=>50]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($ceModel, 'password')->passwordInput(['maxlength'=>20]); ?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('Изменить', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>
</div>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><div class="fr"><span class="fade">если не изменяете, то оставьте поля пустыми</span></div>Изменение пароля</div>
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
                <td width="auto" align="left" colspan="2"><?=Html::submitButton('Изменить', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>
</div>
<div class="sep20"></div>
<div class="box">
    <div class="cell">Сторонние аккаунты</div>
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
        $authed[] = Html::a('<i class="iconfont icon-'.$client->getId().'"></i>&nbsp;&nbsp;<i class="auth-title">'. Html::encode($client->getTitle()) . '</i>', ['service/unbind-account', 'source'=>$client->getId()], ['class'=>'auth-link '. $client->getId(), 'title'=>'Открепить']);
    } else {
        $unauthed[] = Html::a('<i class="iconfont icon-'.$client->getId().'"></i>&nbsp;&nbsp;<i class="auth-title">'. Html::encode($client->getTitle()) . '</i>', ['site/auth', 'authclient'=>$client->getId(), 'action'=>'bind'], ['class'=>'auth-link '. $client->getId(), 'title'=>'Связать']);
    }
}
?>
 <div class="cell">
Связаны&nbsp;&nbsp;<?=implode('&nbsp;&nbsp;&nbsp;&nbsp;', $authed); ?>
 </div>
  <div class="inner">
 Откреплены&nbsp;&nbsp;<?=implode('&nbsp;&nbsp;&nbsp;&nbsp;', $unauthed); ?>
 </div>
    </div>
</div>
</div>
