<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Node;
$settings = Yii::$app->params['settings'];
$title ='导航节点设定';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('导航管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="sep5"></div>
<div class="cell"><?=Html::a('添加新导航', ['add'],['class'=>'super normal button']); ?></div>
<div class="sep5"></div>
<div>
<?php $form = ActiveForm::begin([
			'id' => 'form-navi'
		]); ?>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
	<thead>
		<tr>
<th width="auto" align="center" class="h">节点</th>
<?=($node['type']==1)?'<th width="20" align="center" class="h">显示</th>':''; ?>
<th width="20" align="center" class="h">排序</th>
<th width="20" align="center" class="h" style="border-right: none;">删除</th>
</tr>
	</thead>
	<tbody class="navi-nodes">
<?php
	$key = 0;
	foreach($models as $model) :
	$key++;
?>
		<tr id="node_<?=$key; ?>">
<?php
	echo '<td width="auto" align="center" class="d">', 
			$form->field($model, '['.$key.']node_id')->dropDownList(array(''=>'')+Node::getNodeList(), ['class'=>'nodes-select2 node-id'])->label(false),
			'</td>';
	echo ($node['type']==1)?'<td width="20" align="center" class="d">'.$form->field($model, '['.$key.']visible')->checkbox(['class'=>'visible', 'label' => null]).'</td>':'';
	echo '<td width="20" align="center" class="d">', 
			$form->field($model, '['.$key.']sortid')->textInput(['maxlength' => 2, 'class'=>'form-control sortid'])->label(false),
			'</td><td width="20" align="center" class="d" style="border-right: none;"><span class="navi-nodes-del super normal button">X</span></td>';
?>
		</tr>
<?php
	endforeach;
?>
	</tbody>
	</table>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('确定', ['class' => 'super normal button']); ?> <?=Html::button('添加', ['class' => 'super normal button navi-nodes-add']); ?>
</div>
<?php ActiveForm::end(); ?>
	</div>
</div>
</div>