<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
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
$this->title = Html::encode($settings['site_name']) . ' › 最近的主题  ' . $currentPage . '/'.$pages->pagecount;
}
else{
$this->title = Html::encode($settings['site_name']) . ' › 最近的主题';
}
?>
<div class="box">
<div class="header"><div class="fr f12"><span class="fade">共 <?=$siteinfo['topics'];?> 个主题</span></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 最近的主题</div>
<?php
foreach($topics as $topic){
$topic = $topic['topic'];
$url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="24" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'small', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="small fade">',Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong></span><div class="sep5"></div> <span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo'</span><div class="sep5"></div><span class="small fade">';if ($topic['comment_count']>0) {echo Yii::$app->formatter->asRelativeTime($topic['replied_at']),' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong>';}else{echo Yii::$app->formatter->asRelativeTime($topic['created_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
<?php if($pages->pagecount > 1) {?>
<div class="cell page">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="25%" align="left">
<div class="fl">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>false,'prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i> 上一页']);?></div>
</td>
<td width="50%" align="center">
<strong class="fade"><?=$currentPage . '/'.$pages->pagecount?></strong>
</td>
<td width="25%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'下一页 <i class="iconfont icon-chevronright"></i>','prevPageLabel'=>false]);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>
</div>