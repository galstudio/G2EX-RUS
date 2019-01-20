<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$formatter = Yii::$app->getFormatter();
$session = Yii::$app->getSession();
if( $sms ) {
    $this->title = Html::encode($settings['site_name']).' › Персональные сообщения';
    $title = 'Ответ';
} else {
    $this->title = Html::encode($settings['site_name']).' › Сообщения';
    $title = 'Сообщения';
}
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('Персональные сообщения', ['my/sms']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title;?></div>
<?php if ( $session->hasFlash('SendMsgNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('SendMsgNG');?></div>
<?php } else if ( $session->hasFlash('SendMsgOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('SendMsgOK');?></div>
<?php }?>
<?php if( $sms ): ?>
<div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
        <tbody><tr>
            <td width="100" colspan="2" class="h">Отправитель</td>
            <td width="auto" class="h">Содержание</td>
            <td width="60" class="h" style="border-right: none;">Время</td>
        </tr>
<tr><td align="right" width="30" valign="middle" class="d" style="border-right: none;">
<?=Html::a(Html::img('@web/'.str_replace('{size}', 'small', $sms['source']['avatar']), ['class'=>'avatar fr','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($sms['source']['username'])]);?>
</td><td align="left" width="70" valign="middle" class="d" style="min-width:60px;"><span class="fade">
<?=Html::a(Html::encode($sms['source']['username']), ['user/view', 'username'=>Html::encode($sms['source']['username'])]); ?></td>
<td align="left" valign="top" class="d" style="word-break:break-all"><span class="gray"><?=$sms->msg; ?></span></td>
<td align="left" valign="top" class="d"><span class="fade fr"><?=$formatter->asRelativeTime($sms['created_at']); ?>
</span></td></tr>
</tbody></table>
</div>
<?php endif; ?>
<div class="cell" id="form">
<?php $form = ActiveForm::begin(['id' => 'form-sms']); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
<td width="auto" align="left"><?=$form->field($model, 'username')->textInput(['maxlength'=>16]); ?></td>
</tr>
<tr>
<td width="auto" align="left"><?=$form->field($model, 'msg')->textarea(['rows' => 3, 'maxlength'=>255]); ?></td>
</tr>
<tr>
<td width="auto" align="left">
<?=Html::submitButton('Отправить', ['class' => 'super normal button']); ?>
</td>
</tr>
</tbody></table>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
