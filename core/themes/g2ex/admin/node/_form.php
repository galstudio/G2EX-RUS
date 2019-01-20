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
\app\themes\g2ex\layouts\autosizeAsset::register($this);
?>
<?php $form = ActiveForm::begin(); ?>
<?php
   echo $form->field($model, 'name')->textInput(['maxlength' => 50,'class'=>'sl']);
    echo $form->field($model, 'ename')->textInput(['maxlength' => 50,'class'=>'sl']);
    echo $form->field($model, 'icon')->textInput(['maxlength' => 100,'class'=>'sl','placeholder'=>'static/node/default.png']);
    echo $form->field($model, 'image')->textarea(['rows' => 3,'maxlength' => 10000,'class'=>'sl','placeholder'=>'#Wrapper{}']);
    echo $form->field($model, 'about')->textarea(['rows' => 3, 'maxlength' => 255,'class'=>'sl']);
    echo $form->field($model, 'editor')->dropdownList(['SmdEditor'=>'SimpleMarkdown','WysibbEditor'=>'Wysibb (BBCode)'],['style'=>'width:200px;']);
    echo $form->field($model, 'invisible')->checkbox(['style'=>'margin-left:130px;']);
    echo $form->field($model, 'index')->checkbox(['style'=>'margin-left:130px;']);
    echo $form->field($model, 'access_auth')->checkbox(['style'=>'margin-left:130px;']);
 ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?php echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Правка', ['class' => 'super normal button']); ?>
</div>
<?php ActiveForm::end(); ?>
<script>
autosize(document.querySelectorAll('textarea'));
</script>
