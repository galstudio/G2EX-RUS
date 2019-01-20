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
$cpModel = new ChangePasswordForm();
$ceModel = new ChangeEmailForm();
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › 隐私';
$title = '隐私';
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('设置', ['my/settings']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 隐私</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
您还没有激活，请进入注册时填写的邮箱(<?=$me->email; ?>)，点击激活链接。<br /><br />
<?=Html::a('重发激活邮件', ['service/send-activate-mail']); ?>  <?=Html::a('修改邮箱', ['my/email']); ?>
</div>	
<?php endif; ?>
<?php if ( $session->hasFlash('EditPrivacyNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditPrivacyNG');?></div>
<?php } else if ( $session->hasFlash('EditPrivacyOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditPrivacyOK');?></div>
<?php }?>
<div class="cell_ops" style="line-height: 1.5;">
        <img src="/static/images/privacy64.png" width="50" border="0" align="left" style="margin-right: 20px;"><?=Html::encode($settings['site_name']);?> 是一个提供公开讨论的网络社区。你可以在这里参与技术讨论、发布招聘或者求职信息、或是分享自己最近发现的好玩新奇。你在 <?=Html::encode($settings['site_name']);?> 发布的主题和回复会永久保存，这样所有曾经参与讨论的人都可以始终看到整个讨论串的全貌。如果你希望对你发布在这里的信息的可见性进行一些控制，你可以使用下面的这些选项。
    </div>
<div class="inner">
<?php $form = ActiveForm::begin(['action' => ['service/edit-privacy'],'id' => 'form']); ?>
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'email_close')->dropdownList(['0'=>'显示','1'=>'隐藏']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'topic_close')->dropdownList(['0'=>'显示','1'=>'隐藏']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'comment_close')->dropdownList(['0'=>'显示','1'=>'隐藏']);?></td>
            </tr>
            <tr>
                <td width="90" align="right"></td>
                <td width="auto" align="left"><?=Html::encode($settings['site_name']);?>  是一个提供公共讨论的在线社区，因此默认情况下，你的 <?=Html::a('主题列表', ['user/view', 'username'=>Html::encode($me->username)]);?>会被所有用户看到，无论他们是否注册。如果你希望对此进行限制，那么你可以选择只让注册用户可以看到，或者只有自己可以看到。
                <div class="sep5"></div>
                但是无论如何设置，只要主题没有位于隐藏节点，只要知道主题的 ID，别人依然可以通过主题 ID 找到你发布的内容。
                <div class="sep5"></div>
                当你在使用 <?=Html::encode($settings['site_name']);?>  时，你要明白你发布到这个网站上的大部分信息都是完全公开的。因此，如果有什么特定信息是你不希望别人知道的，那就不要发布到 <?=Html::encode($settings['site_name']);?>  上。
                <div class="sep5"></div>
                而无论如何设置，为了保证其他用户的安全，所有交易类主题的列表，会始终显示。
                <div class="sep5"></div>
                </td>
            </tr>
            <tr>
                <td width="90" align="right"></td>
                <td width="auto" align="left" class="set"><?=Html::submitButton('保存隐私设置', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>

</div>
</div>