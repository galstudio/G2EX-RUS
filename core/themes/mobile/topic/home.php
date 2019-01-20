<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Node;
use app\models\Navi;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="cell" style="background-color: #fff; border-top-left-radius: 3px; border-top-right-radius: 3px;" id="Tabs">
<?php
echo Html::a('全部', ['topic/home'], ['class'=>'tab_current']);
$navis = Navi::getHeadNaviNodes();
foreach($navis as $current) {
echo Html::a(Html::encode($current['name']), ['topic/navi', 'name'=>$current['ename']], ['class'=>'tab']);
}if(!$isGuest){
echo Html::a('节点', ['topic/nodes'], ['class'=>'tab']);
echo Html::a('关注', ['topic/members'], ['class'=>'tab']);}
?>
</div>
<?php if(!empty($navi['visibleNaviNodes'])) : ?>
<div class="cell" style="background-color: #f9f9f9; padding:10px;">
<?php
foreach($navi['visibleNaviNodes'] as $current) {
$current = $current['node'];
echo Html::a(Html::encode($current['name']), ['topic/node', 'name'=>$current['ename']]);
}?>
</div>
<?php endif; ?>
<?php
foreach($topics as $topic){
$topic = $topic['topic'];
$url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="24" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'small', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="small fade">',Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong></span><div class="sep5"></div> <span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo'</span><div class="sep5"></div><span class="small fade">';if ($topic['comment_count']>0) {echo Yii::$app->formatter->asRelativeTime($topic['replied_at']),' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong>';}else{echo Yii::$app->formatter->asRelativeTime($topic['created_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
<div class="inner" style="text-align: right;">
<?php if(!$isGuest){?>
<div class="fl">&nbsp;
<div style="width: 250px; background-color: #f0f0f0; height: 3px; display: inline-block; vertical-align: middle;text-align: left;"><div style="width: <?=($me->score / SfHtml::uGroupNext($me->score) *100);?>%;max-width: 100%; background-color: #a9de62; height: 3px; display: inline-block;"></div></div>
</div><?php }?>
<?=Html::a('更多 →', ['topic/recent']);?>
    </div>
</div>
<div class="sep5"></div>
<?php
if ( intval($settings['cache_enabled'])===0 || $this->beginCache('f-bottom-nodes', ['duration' => intval($settings['cache_time'])*60])) :
?>
<div class="box">
    <div class="cell"><div class="fr"><?=Html::a('浏览全部节点 →', ['node/index']); ?></div><span class="fade"><strong><?=$settings['site_name']?></strong> / 节点导航</span></div><?php $bNavis = Navi::getBottomNaviNodes();foreach($bNavis as $cNavi) :?>
    <div class="cell"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="right" width="60"><span class="fade"><?=Html::encode($cNavi['name']); ?></span></td><td style="line-height: 200%; font-size:14px; padding-left: 10px; word-break: keep-all;"><?php foreach($cNavi['naviNodes'] as $cNode) {$cNode = $cNode['node'];echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']]),'&nbsp; &nbsp; ';}?></td></tr></table></div><?php endforeach;?>
</div>
<?php if ( intval($settings['cache_enabled']) !== 0 ) {$this->endCache();}endif;?>
</div>