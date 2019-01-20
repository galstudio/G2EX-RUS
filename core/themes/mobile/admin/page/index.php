<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
$settings = Yii::$app->params['settings'];
$title ='单页管理';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$currentPage = $pages->page+1;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="cell"><?=Html::a('添加新单页', ['add'],['class'=>'super normal button']); ?></div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="20" align="center" class="h">ID</th>
<th width="30" align="center" class="h">排序</th>
<th width="auto" align="center" class="h">单页名</th>
<th width="auto" align="center" class="h">单页英文名</th>
<th width="35" align="center" class="h" style="border-right: none;">操作</th>
</tr>
<?php
foreach($single as $page) {
echo '<tr><td width="20" align="center" class="d">', $page['id'], '</td><td width="30" align="center" class="d">', $page['sortid'], '</td><td width="auto" align="center" class="d">', $page['name'], '</td><td width="auto" align="center" class="d">', $page['ename'], '</td><td width="35" align="center" class="d" style="border-right: none;">', 
Html::a('编辑', ['edit', 'id'=>$page['id']],['class' => 'super normal button']), '<br><br>', 
Html::a('删除', ['delete', 'id'=>$page['id']] ,['class' => 'super normal button',
    'data' => [
        'confirm' => '注意：删除后将不会恢复！确认删除！',
        'method' => 'post',
]]), '</td></tr>';
}?>
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