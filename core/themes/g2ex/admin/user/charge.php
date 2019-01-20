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
$title = 'Правка информации';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Пользователи', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
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
            <?=Html::submitButton('Изменить', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
