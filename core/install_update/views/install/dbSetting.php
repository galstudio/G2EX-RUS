<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › База данных';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']) , ['/']), '<span class="chevron">&nbsp;›&nbsp;</span>База данных';?></div>
<?php if ( !empty($error) ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?php echo $error;?></div>
<?php }?>
<div class="cell form">
<?php $form = ActiveForm::begin([
'layout' => 'horizontal',
'id' => 'form-dbinfo'
]); ?>
<?php echo $form->field($model, 'host')->hint('&nbsp;обычно localhost'); ?>
<?php echo $form->field($model, 'dbname'); ?>
<?php echo $form->field($model, 'username'); ?>
<?php echo $form->field($model, 'password'); ?>
<?php echo $form->field($model, 'tablePrefix'); ?>
<div class="form-group">
	<label class="control-label"> &nbsp;&nbsp;</label>
    <?php echo Html::submitButton('Далее', ['class' => 'super normal button', 'name' => 'dbsetting-button']); ?>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
