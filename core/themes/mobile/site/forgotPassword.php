<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$session = Yii::$app->getSession();
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']). ' › 通过电子邮件重设密码';
$title = '通过电子邮件重设密码';
?>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 通过电子邮件重设密码</div>
<?php $form = ActiveForm::begin(['id' => 'form']); ?>
<?=$form->field($model, 'email')->textInput(['maxlength'=>50]); ?>
<div class="sep5"></div>
<?=Html::submitButton('继续', ['class' => 'super normal button','style'=>'width:100px;']);?>
<div class="c"></div>
<div class="sep5"></div>
 <?php ActiveForm::end(); ?>
    </div>
</div>