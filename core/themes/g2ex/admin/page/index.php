<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
$settings = Yii::$app->params['settings'];
$title ='Страницы';
$currentPage = $pages->page+1;
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="cell"><?=Html::a('Создать', ['add'],['class'=>'super normal button']); ?></div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="50" align="center" class="h">ID</th>
<th width="40" align="center" class="h">Порядок</th>
<th width="auto" align="center" class="h">Название</th>
<th width="auto" align="center" class="h">Алиас</th>
<th width="180" align="center" class="h" style="border-right: none;">Действие</th>
</tr>
<?php
foreach($single as $page) {
echo '<tr><td width="50" align="center" class="d">', $page['id'], '</td><td width="40" align="center" class="d">', $page['sortid'], '</td><td width="auto" align="center" class="d">', $page['name'], '</td><td width="auto" align="center" class="d">', $page['ename'], '</td><td width="120" height="20" align="center" class="d" style="border-right: none;">',
Html::a('Правка', ['edit', 'id'=>$page['id']],['class' => 'super normal button']), '&nbsp; &nbsp;',
Html::a('Удалить', ['delete', 'id'=>$page['id']] ,['class' => 'super normal button',
    'data' => [
        'confirm' => 'Примечание: После удаления восстановление невозможно! Подтвердите удаление!',
        'method' => 'post',
]]), '</td></tr>';
}?>
</tbody></table>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>
</div>
</div>
</div>
