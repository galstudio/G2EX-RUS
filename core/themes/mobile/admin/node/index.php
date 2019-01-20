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
$title ='节点管理';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$currentPage = $pages->page+1;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="cell"><?=Html::a('创建新节点', ['add'],['class'=>'super normal button']); ?></div>
<div class="form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?=$form->field($model, 'name')->textInput(['maxlength' => 50,'class'=>'sl']);; ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('搜索节点', ['class' => 'super normal button']); ?>
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
foreach($nodes as $node) {
echo '<tr><td width="20" align="center" class="d">', $node['id'],'</td><td width="30" align="center" class="d">'; if ($node['access_auth']>0){echo '<span class="negative">是</span>';}else{echo '<span class="positive">否</span>';}echo '</td><td width="30" align="center" class="d">'; if ($node['invisible']=0){echo '<span class="negative">显</span>';}else{echo '<span class="positive">隐</span>';}echo '</td><td width="auto" height="20" align="center" class="d">',Html::encode($node['name']), '</td><td width="auto" height="20" align="center" class="d">',Html::encode($node['ename']), '</td><td width="35" align="center" class="d" style="border-right: none;">', 
Html::a('编辑', ['edit', 'id'=>$node['id']],['class' => 'super normal button']), 
 '</td></tr>';}?>
</tbody></table>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="75%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="25%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>
</div>
</div>