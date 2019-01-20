<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › 购买邀请码';
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('邀请码', ['my/invite-codes']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 购买邀请码</div>
<div class="cell" id="form">
<?php $form = ActiveForm::begin(['id' => 'form-buy-invite-codes']); ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
<td width="auto" align="left"><?=$form->field($model, 'amount')->textInput(['maxlength'=>3]); ?></td>
</tr>
<tr>
<td width="auto" align="left">
<?=$form->field($model, 'password')->passwordInput(['maxlength'=>20]); ?></td>
</tr>
<tr>
<td width="auto" align="left">
<?=Html::submitButton('确定', ['class' => 'super normal button']); ?>
</td>
</tr>
</tbody></table>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>