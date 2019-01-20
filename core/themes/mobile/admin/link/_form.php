<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
?>
<div id="form">
<?php $form = ActiveForm::begin(); ?>
<?php
	echo $form->field($model, 'name')->textInput(['maxlength' => 20,'class'=>'sl']);
	echo $form->field($model, 'url')->textInput(['maxlength' => 100,'class'=>'sl']);
	echo $form->field($model, 'sortid')->textInput(['maxlength' => 2,'class'=>'sl'])->hint('数字越小越靠前，默认99');
?>
	<div class="form-group">
	<label class="control-label"> &nbsp;&nbsp;</label>
		<?=Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => 'super normal button']); ?>
	</div>
<?php ActiveForm::end(); ?>
</div>