<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
$settings = Yii::$app->params['settings'];
$title ='Теги';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$currentPage = $pages->page+1;
$formatter = Yii::$app->getFormatter();
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Теги', ['index']);?></div>
<div class="box">
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
<th width="20" align="center" class="h">ID</th>
<th width="40" align="center" class="h">Тег</th>
<th width="40" align="center" class="h">Топики</th>
<th width="40" align="center" class="h">Создан</th>
<th width="40" align="center" class="h">Обновлен</th>
<th width="50" align="center" class="h" style="border-right: none;">Действия</th>
</tr>
<?php
foreach($tags as $tag) {
echo '<tr><td align="center" class="d">', $tag['id'], '</td>
<td align="center" class="d">', Html::a(Html::encode($tag['name']), ['tag/index', 'name'=>$tag['name']], ['target'=>'_blank']), '</td>
<td align="center" class="d">', $tag['topic_count'], '</td>
<td align="center" class="d">', $formatter->asDateTime($tag['created_at'], 'dd.MM.y HH:mm') ,'</td>
<td align="center" class="d">', $formatter->asDateTime($tag['updated_at'], 'dd.MM.y HH:mm') ,'</td>
<td align="center" height="20" class="d" style="border-right: none;">', Html::a('Правка', ['edit', 'id'=>$tag['id']],['class' => 'super normal button']).'&nbsp;&nbsp;',
Html::a('Удалить', ['delete', 'id'=>$tag['id']], [
'data' => [
'confirm' => 'Примечание: После удаления восстановление невозможно! Подтвердите удаление!',
'method' => 'post',
],'class' => 'super normal button']), '</td>
</tr>';}?>
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
