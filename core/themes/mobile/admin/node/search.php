<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$title ='搜索节点';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('节点管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="cell"><?=Html::a('创建新节点', ['add'],['class'=>'super normal button']); ?></div>
<div class="form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?=$form->field($model, "name"); ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('搜索节点', ['class' => 'super normal button', 'name' => 'login-button']); ?>
</div>
<?php ActiveForm::end();?>
</div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="20" align="center" class="h">ID</th>
<th width="30" align="center" class="h">登录</th>
<th width="30" align="center" class="h">首页</th>
<th width="auto" align="center" class="h">节点名</th>
<th width="auto" align="center" class="h">英文名</th>
<th width="35" align="center" class="h" style="border-right: none;">操作</th>
</tr>
<?php
if( !empty($node) ) {
echo '<tr><td width="20" align="center" class="d">', $node['id'],'</td><td width="30" align="center" class="d">'; if ($node['access_auth']>0){echo '<span class="negative">是</span>';}else{echo '<span class="positive">否</span>';}echo '</td><td width="30" align="center" class="d">'; if ($node['index']>0){echo '<span class="negative">显</span>';}else{echo '<span class="positive">隐</span>';}echo '</td><td width="auto" height="20" align="center" class="d">',Html::encode($node['name']), '</td><td width="auto" height="20" align="center" class="d">',Html::encode($node['ename']), '</td><td width="35" align="center" class="d" style="border-right: none;">', 
Html::a('编辑', ['edit', 'id'=>$node['id']],['class' => 'super normal button']), 
 '</td></tr>';
} else {echo '<tr><td width="auto" align="center" colspan="3">搜索的节点不存在</td></tr>';};?>
</tbody></table>
</div>
</div>
</div>