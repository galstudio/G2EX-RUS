<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']). ' › 重设密码';
$title = '重设密码';
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 重设密码</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<?=$form->field($model, 'password')->passwordInput(['maxlength'=>20]); ?>
<?=$form->field($model, 'password_repeat')->passwordInput(['maxlength'=>20]); ?>
<div class="sep5"></div>
<?=Html::submitButton('保存新密码', ['class' => 'super normal button']);?>
<div class="c"></div>
<div class="sep5"></div>
 <?php ActiveForm::end(); ?>
    </div>
</div>
