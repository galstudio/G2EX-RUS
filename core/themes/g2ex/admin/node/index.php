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
$title ='Управление темами';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$currentPage = $pages->page+1;
?>
<?php echo $this->render('@app/views/common/login'); ?>
<?php echo $this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Управление темами', ['index']);?></div>
<div class="box">
<div class="cell"><?php echo Html::a('Создать тему', ['add'],['class'=>'super normal button']); ?></div>
<div class="cell form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?php echo $form->field($model, "name"); ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?php echo Html::submitButton('Найти тему', ['class' => 'super normal button', 'name' => 'login-button']); ?>
</div>
<?php ActiveForm::end();?>
</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="20" align="center" class="h">ID</th>
<th width="auto" align="center" class="h">просмотр после авторизации</th>
<th width="auto" align="center" class="h">топики только в этой теме</th>
<th width="auto" align="center" class="h">иконка</th>
<th width="auto" align="center" class="h">имя темы</th>
<th width="auto" align="center" class="h">алиас</th>
<th width="auto" align="center" class="h" style="border-right: none;">действия</th>
</tr>
<?php
foreach($nodes as $node) {
echo '<tr><td align="center" class="d">', $node['id'],'</td><td align="center" class="d">'; if ($node['access_auth']>0){echo '<span class="negative">да</span>';}else{echo '<span class="positive">нет</span>';}echo '</td><td align="center" class="d">'; if ($node['invisible']==0){echo '<span class="negative">нет</span>';}else{echo '<span class="positive">да</span>';}echo '</td><td align="center" class="d">';if ($node['icon']){echo '<img src="/', $node['icon'],'" height="30">';}echo '</td><td align="center" class="d">',Html::encode($node['name']), '</td><td  align="center" class="d">',Html::encode($node['ename']), '</td><td align="center" class="d" style="border-right: none;">',
Html::a('правка', ['edit', 'id'=>$node['id']],['class' => 'super normal button']),
 '</td></tr>';}?>
</tbody></table>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
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
</div>
