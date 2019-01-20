<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$session = Yii::$app->getSession();
$title = '积分充值';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('会员管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<?php if ( $session->hasFlash('ChargePointNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('ChargePointNG');?></div>
<?php } else if ( $session->hasFlash('ChargePointOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('ChargePointOK');?></div>
<?php }?>
<div class="cell form">
<?php $form = ActiveForm::begin(['layout' => 'horizontal',]); ?>
        <?=$form->field($model, 'username')->textInput(['maxlength'=>16]); ?>
            <?=$form->field($model, 'point')->textInput(['maxlength'=>8]); ?>
            <?=$form->field($model, 'msg')->textarea(['rows' => 3, 'maxlength'=>255]); ?>
        <div class="form-group">
            <label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('确定', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end(); ?>
</div>
</div>