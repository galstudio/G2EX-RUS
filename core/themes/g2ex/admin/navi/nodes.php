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
$title ='Настройка навигации тем';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Управление навигацией', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="cell"><?=Html::a('Добавить навигацию', ['add'],['class'=>'super normal button']); ?></div>
<div class="form">
<?php $form = ActiveForm::begin([
			'id' => 'form-navi'
		]); ?>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
	<thead>
		<tr>
<th width="auto" align="center" class="h">тема</th>
<?=($node['type']==1)?'<th width="50" align="center" class="h">отображение</th>':''; ?>
<th width="50" align="center" class="h">порядок</th>
<th width="50" align="center" class="h" style="border-right: none;">удалить</th>
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
	echo ($node['type']==1)?'<td width="50" align="center" class="d">'.$form->field($model, '['.$key.']visible')->checkbox(['class'=>'visible', 'label' => null]).'</td>':'';
	echo '<td width="50" align="center" class="d">',
			$form->field($model, '['.$key.']sortid')->textInput(['maxlength' => 2, 'class'=>'form-control sortid'])->label(false),
			'</td><td width="50" align="center" class="d" style="border-right: none;"><span class="navi-nodes-del super normal button">X</span></td>';
?>
		</tr>
<?php
	endforeach;
?>
	</tbody>
	</table>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('Определить', ['class' => 'super normal button']); ?> <?=Html::button('Добавить', ['class' => 'super normal button navi-nodes-add']); ?>
</div>
<?php ActiveForm::end(); ?>
	</div>
</div>
</div></div>
