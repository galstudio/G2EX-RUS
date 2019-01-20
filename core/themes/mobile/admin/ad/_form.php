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
$this->registerJs('$(".nodes-select2").select2({placeholder:"所有节点显示",allowClear: true});');
?>
<?php $form = ActiveForm::begin(['id' => 'form']); 
    echo $form->field($model, 'name')->textInput(['maxlength' => 20,'class'=>'sl']); 
    echo $form->field($model, 'node_id')->dropDownList(array(''=>'')+Node::getNodeList(), ['class'=>'nodes-select2','style'=>'width:130px;']); 
    echo $form->field($model, 'expires')->textInput(['maxlength' => 10,'class'=>'sl']); 
    echo $form->field($model, 'sortid')->textInput(['maxlength' => 2,'class'=>'sl']); 
    echo $form->field($model, 'content')->textArea(['class'=>'sl','style'=>'width:180px;height:300px;']); 
    echo $form->field($model, 'invisible')->checkbox(['style'=>'margin-left:100px;']);
    ?>
	<div class="form-group">
	<label class="control-label"> &nbsp;&nbsp;</label>
		<?=Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => 'super normal button']); ?>
	</div>
<?php ActiveForm::end(); ?>