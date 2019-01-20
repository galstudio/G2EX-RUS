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
$this->title = Html::encode($settings['site_name']).' › Приватность';
$title = 'Приватность';
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('Настройки', ['my/settings']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Приватность</div>
<?php if ($me->isWatingActivation()) : ?>
<?php if ( $session->hasFlash('activateMailNG') ) {echo  '<div class="problem">'.$session->getFlash('activateMailNG').'</div>';
} else if ( $session->hasFlash('activateMailOK') ) {echo '<div class="message">'.$session->getFlash('activateMailOK').'</div>';}?>
<div class="problem">
Вы не активировали, указанный при регистрации Email: (<?=$me->email; ?>).<br /><br />
<?=Html::a('Повторно отправить сообщение с кодом активации', ['user/send-activate-mail']); ?>  <?=Html::a('Изменить Email', ['user/email']); ?>
</div>
<?php endif; ?>
<?php if ( $session->hasFlash('EditPrivacyNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditPrivacyNG');?></div>
<?php } else if ( $session->hasFlash('EditPrivacyOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('EditPrivacyOK');?></div>
<?php }?>
<div class="cell_ops" style="line-height: 1.5;">
        <img src="/static/images/privacy64.png" width="50" border="0" align="left" style="margin-right: 20px;">Сообщество <?=Html::encode($settings['site_name']);?> является открытой площадкой для общения пользователей. Здесь вы можете участвовать в обсуждении разных вопросов и проблем, рассказывать о своей работе или карьере, или просто делиться своими новостями. Всё, что вы пишите в темах, топиках и комментариях сохраняется, так что  всегда можно увидеть полную ветвь дискуссии. Если вы хотите по какой-либо причине скрыть информацию, которую вы здесь размещаете, то можете воспользоваться параметрами ниже.
    </div>
<div class="inner">
<?php $form = ActiveForm::begin(['action' => ['service/edit-privacy'],'id' => 'form']); ?>
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'email_close')->dropdownList(['0'=>'показывать','1'=>'скрыть']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'topic_close')->dropdownList(['0'=>'показывать','1'=>'скрыть']);?></td>
            </tr>
            <tr>
                <td width="auto" align="left" colspan="2"><?=$form->field($me->userInfo, 'comment_close')->dropdownList(['0'=>'показывать','1'=>'скрыть']);?></td>
            </tr>
            <tr>
                <td width="120" align="right"></td>
                <td width="auto" align="left">По умолчанию все пользователи, независимо от того зарегистрированы они или нет, видят все дискуссии <?=Html::encode($settings['site_name']);?>  и  <?=Html::a('вашу страницу', ['user/view', 'username'=>Html::encode($me->username)]);?>. Если вы хотите ограничить просмотр, то можете разрешить только зарегистрированным пользователя просматривать вашу информацию.
                <div class="sep10"></div>
                Но учтите, что независимо от установок системы, до тех пор пока топик не находится в закрытой теме, то его еще можно найти по ID.
                <div class="sep10"></div>
                При общении на <?=Html::encode($settings['site_name']);?>, вы должны понимать, что публикуемая большая часть информации вляется полностью открытой. Поэтому, если есть какая-либо конкретная информация, которую вы не хотите, чтобы знали другие, то не публикуйте её на <?=Html::encode($settings['site_name']);?>.
                <div class="sep10"></div>
                Независимо от установок системы, в целях обеспечения безопасности других пользователей, список всех операций всегда отображается.
                <div class="sep10"></div>
                </td>
            </tr>
            <tr>
                <td width="120" align="right"></td>
                <td width="auto" align="left" class="set"><?=Html::submitButton('Сохранить', ['class' => 'super normal button']); ?></td>
            </tr>
        </tbody></table>
<?php ActiveForm::end(); ?>
    </div>
</div>
</div>
