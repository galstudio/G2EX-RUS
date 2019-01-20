<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Node;
use app\models\Navi;
use app\models\Siteinfo;
$siteinfo = Siteinfo::getSiteInfo();
$settings = Yii::$app->params['settings'];
$currentPage = $pages->page+1;
if($pages->pagecount > 1) {
$this->title = Html::encode($settings['site_name']) . ' › 搜索结果  ' . $currentPage . '/'.$pages->pagecount;
}
else{
$this->title = Html::encode($settings['site_name']) . ' › 搜索结果';
}
?>
<?php echo $this->render('@app/views/common/login'); ?>
<?php echo $this->render('@app/views/common/mynode'); ?>
<?php echo $this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><div class="fr f12"><span class="fade">共 <?php echo $pages->totalCount;?> 个主题</span></div><?php echo Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <strong class="negative"><?php echo $title;?></strong> 的搜索结果</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?q=<?php echo Yii::$app->request->get('q') ?>&p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?q=<?php echo Yii::$app->request->get('q') ?>&p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<?php
foreach($topics as $topic){
$topic = $topic['topic'];
$url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="48" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo '</span><div class="sep5"></div><span class="small fade">';if ($topic['vote_count']>0){echo '<div class="votes"><i class="iconfont icon-chevronup"></i> &nbsp;'.$topic['vote_count'].' &nbsp;&nbsp; </div>';}echo Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['created_at']);if ($topic['comment_count']>0) {echo ' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['replied_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?q=<?php echo Yii::$app->request->get('q') ?>&p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?q=<?php echo Yii::$app->request->get('q') ?>&p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php };?>
</div>
</div>
