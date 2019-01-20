<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
?>
<?php $form = ActiveForm::begin(); ?>
<?php
   echo $form->field($model, 'name')->textInput(['maxlength' => 50,'class'=>'sl']);
    echo $form->field($model, 'ename')->textInput(['maxlength' => 50,'class'=>'sl']);
    echo $form->field($model, 'icon')->textInput(['maxlength' => 100,'class'=>'sl','placeholder'=>'static/node/default.png']);
    echo $form->field($model, 'image')->textarea(['rows' => 3,'maxlength' => 10000,'class'=>'sl','placeholder'=>'#Wrapper{}']);
    echo $form->field($model, 'about')->textarea(['rows' => 3, 'maxlength' => 255,'class'=>'sl']);
    echo $form->field($model, 'editor')->dropdownList(['SmdEditor'=>'SimpleMarkdown编辑器','WysibbEditor'=>'Wysibb编辑器(BBCode)'],['style'=>'width:200px;']);
    echo $form->field($model, 'invisible')->checkbox(['style'=>'margin-left:110px;']);
    echo $form->field($model, 'index')->checkbox(['style'=>'margin-left:110px;']);
    echo $form->field($model, 'access_auth')->checkbox(['style'=>'margin-left:110px;']);
 ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
	<?=Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => 'super normal button']); ?>
</div>
<?php ActiveForm::end(); ?>
