<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use app\models\Favorite;
use app\models\User;
$currentPage = $pages->page+1;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']);
$title = Html::encode($settings['site_name']).' › '.Html::encode($user['username']).'在 '.$this->title.' 创建的主题';
$formatter = Yii::$app->getFormatter();
?>
<div class="box">
<div class="header"><?php if ($user['userInfo']['topic_close']==0){?><div class="fr f12"><span class="snow">主题总数&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?php };?><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a(Html::encode($user['username']),['user/view', 'username'=>Html::encode($user['username'])]); ?> <span class="chevron">&nbsp;›&nbsp;</span> 全部主题</div>
<?php if ($user['userInfo']['topic_close']==1){?>
<div class="inner"><table cellpadding="0" cellspacing="10" border="0" width="100%">
<tbody><tr>
    <td width="200" align="center"><img src="/static/images/lock256.png" border="0" width="128"></td>
    <td width="auto" align="left" class="topic_content"><span class="gray">根据 <?=Html::encode($user['username'])?> 的设置，主题列表被隐藏</span></td>
</tr>
</tbody></table></div>
<?php }else{ ?>
<?php
foreach($topics as $topic){
    $topic = $topic['topic'];
    $url = ['topic/view', 'id'=>$topic['id']];
    echo '<div class="cell item"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="24" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'small', $user['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($user['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="small fade">';if ($topic['vote_count']>0){echo '<div class="votes"><i class="iconfont icon-chevronup"></i> &nbsp;'.$topic['vote_count'].' &nbsp;&nbsp; </div>';}echo Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($user['username']),['user/view', 'username'=>Html::encode($user['username'])]),'</strong><div class="sep5"></div> <span class="item_title">',Html::a(Html::encode($topic['title']), $url);if ($topic['alltop']==1){echo ' <i class="iconfont">&#xe610;</i>';}if ($topic['top']==1){echo ' <i class="iconfont">&#xe60e;</i>';}if ($topic['star']==1){echo ' <i class="iconfont">&#xe614;</i>';}if ($topic['comment_count']>10&&$topic['views']>300){echo ' <i class="iconfont">&#xe603;</i>';}echo '</span><div class="sep5"></div>',Yii::$app->formatter->asRelativeTime($topic['created_at']);if ($topic['comment_count']>0) {echo ' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['replied_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
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
<?php };?>
</div>
</div>