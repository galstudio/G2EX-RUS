<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$title ='邮件测试';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="cell form">
<?php if ( $rtnCd === 9 ) {?>
<div class="problem" onclick="$(this).slideUp('fast');">测试邮件发送出错，请确认 <?=Html::a('SMTP邮箱设置', ['admin/setting', '#'=>'mailer']) . ' 是否正确。';?></div>
<?php } else if ( $rtnCd === 1 ) {?>
<div class="message" onclick="$(this).slideUp('fast');">测试邮件发送成功，请进测试邮箱查看是否收到。</div>
<?php }?>

<?php $form = ActiveForm::begin([
		'action' => ['admin/setting/test-email'],
		'layout' => 'horizontal',
		]); ?>
		<?=$form->field($model, 'email')->textInput(['maxlength'=>50]); ?>
		<?=$form->field($model, 'content')->textArea(['maxlength'=>255]); ?>
        <div class="form-group">
			<label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('<i class="fa fa-send"></i> &nbsp;测试', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
