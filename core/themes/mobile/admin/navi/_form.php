<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Navi;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
?>
<?php $form = ActiveForm::begin();
$naviTypes = json_decode(Navi::TYPES,true);
if($type === 'edit') {
?>
<div class="form-group">
<label class="control-label">类型</label>
<div style="padding-top:7px;">
<strong><?php echo $naviTypes[$model->type]; ?></strong>
</div>
</div>
<?php
} else {
echo $form->field($model, 'type')->dropDownList($naviTypes);
}
echo $form->field($model, 'name')->textInput(['maxlength' => 20]);
echo $form->field($model, 'ename')->textInput(['maxlength' => 20]);
echo $form->field($model, 'sortid')->textInput(['maxlength' => 2])->hint('数字越小越靠前');
?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?php echo Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => 'super normal button']); ?>
</div>
<?php ActiveForm::end(); ?>
