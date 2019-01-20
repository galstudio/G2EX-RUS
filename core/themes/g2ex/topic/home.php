<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Node;
use app\models\Navi;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$isGuest = Yii::$app->getUser()->getIsGuest();
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/mynode'); ?>
<?=$this->render('@app/views/common/ad'); ?>
<?=$this->render('@app/views/common/hot'); ?>
<?=$this->render('@app/views/common/hotnode'); ?>
<?=$this->render('@app/views/common/newnode'); ?>
<?=$this->render('@app/views/common/siteinfo'); ?>
<?=$this->render('@app/views/common/link'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="inner" style="background-color: #fff; border-top-left-radius: 3px; border-top-right-radius: 3px;" id="Tabs">
<?php
echo Html::a('Лента', ['topic/home'], ['class'=>'tab_current']);
$navis = Navi::getHeadNaviNodes();
foreach($navis as $current) {
echo Html::a(Html::encode($current['name']), ['topic/navi', 'name'=>$current['ename']], ['class'=>'tab']);
}if(!$isGuest){
echo Html::a('Темы', ['topic/nodes'], ['class'=>'tab']);
echo Html::a('Пользователи', ['topic/members'], ['class'=>'tab']);}
?>
</div>
<div class="cell" style="background-color: #f9f9f9; padding:10px;">
<?php
$Index = Node::getIndexNodes();
foreach($Index as $nn) {
    echo Html::a(Html::encode($nn['name']), ['topic/node', 'name'=>$nn['ename']]),' &nbsp; &nbsp; ';
}?>
</div>
<div id="topic_list">
<?php
foreach($topics as $topic){
$topic = $topic['topic'];
$url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="48" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo '</span><div class="sep5"></div><span class="small fade">';if ($topic['vote_count']>0){echo '<div class="votes"><i class="iconfont icon-chevronup"></i> &nbsp;'.$topic['vote_count'].' &nbsp;&nbsp; </div>';}echo Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['created_at']);if ($topic['comment_count']>0) {echo ' &nbsp;•&nbsp; Последний комментарий от <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['replied_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
<div class="inner">
        <span class="chevron">→</span> <?=Html::a('новые записи', ['topic/recent']);?>
    </div>
</div></div>
<div class="sep20"></div>
<?php
if ( intval($settings['cache_enabled'])===0 || $this->beginCache('f-bottom-nodes', ['duration' => intval($settings['cache_time'])*60])) :
?>
<div class="box">
    <div class="cell"><div class="fr"><?=Html::a('все темы', ['node/index']); ?></div><span class="fade"><strong><?=$settings['site_name']?></strong> / Навигация</span></div><?php $bNavis = Navi::getBottomNaviNodes();foreach($bNavis as $cNavi) :?>
    <div class="cell"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="right" width="60"><span class="fade"><?=Html::encode($cNavi['name']); ?></span></td><td style="line-height: 200%; font-size:14px; padding-left: 10px; word-break: keep-all;"><?php foreach($cNavi['naviNodes'] as $cNode) {$cNode = $cNode['node'];echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']]),'&nbsp; &nbsp; ';}?></td></tr></table></div><?php endforeach;?>
</div>
<?php if ( intval($settings['cache_enabled']) !== 0 ) {$this->endCache();}endif;?>
</div>
