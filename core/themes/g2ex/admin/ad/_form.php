<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ad;
use app\models\Node;
\app\assets\Select2Asset::register($this);
$this->registerJs('$(".nodes-select2").select2({placeholder:"Во всех темах",allowClear: true});');
?>
<?php $form = ActiveForm::begin(['id' => 'form']);
    echo $form->field($model, 'name')->textInput(['maxlength' => 20,'class'=>'sl']);
    echo $form->field($model, 'node_id')->dropDownList(array(''=>'')+Node::getNodeList(), ['class'=>'nodes-select2','style'=>'width:320px;']);
    echo $form->field($model, 'expires')->textInput(['maxlength' => 10,'class'=>'sl'])->hint('формат: 2020-12-12');
    echo $form->field($model, 'sortid')->textInput(['maxlength' => 2,'class'=>'sl'])->hint('чем меньше число, тем выше, по умолчанию 50');
    echo $form->field($model, 'content')->textArea(['class'=>'sl','style'=>'width:500px;height:300px;'])->hint('разрешен HTML');
    echo $form->field($model, 'invisible')->checkbox(['style'=>'margin-left:130px;']);
    ?>
	<div class="form-group">
	<label class="control-label"> &nbsp;&nbsp;</label>
		<?php echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => 'super normal button']); ?>
	</div>
<?php ActiveForm::end(); ?>
