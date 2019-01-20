<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Favorite;
use app\models\User;
use app\components\SfHtml;
\app\themes\g2ex\layouts\highlightAsset::register($this);
$this->title = Html::encode($user['username']);
$settings = Yii::$app->params['settings'];
$formatter = Yii::$app->getFormatter();
$isGuest = Yii::$app->getUser()->getIsGuest();
if (!$isGuest) {
	$me = Yii::$app->getUser()->getIdentity();
}
$userOp = [];
if (!$isGuest && $me->isActive() && $me->id != $user['id']) {
   
    $userOp['follow'] = Favorite::checkFollow($me->id, Favorite::TYPE_USER, $user['id'])?Html::a('<span class="favorite-name">取消特别关注</span>', null, ['class'=>'favorite super button inverse', 'title'=>'取消特别关注', 'href' => 'javascript:void(0);', 'params'=>'unfavorite user '. $user['id']]).'<div class="sep20"></div>':Html::a('<span class="favorite-name">加入特别关注</span>', null, ['class'=>'favorite super button special', 'title'=>'加入特别关注', 'href' => 'javascript:void(0);', 'params'=>'favorite user '. $user['id']]).'<div class="sep20"></div>';
     $userOp['sms'] = Html::a('私信Ta', ['service/sms', 'to'=>Html::encode($user['username'])], ['class'=>'super normal button']);
     if (!$isGuest && $me->isAdmin() && $me->id != $user['id']) {
    $userOp['manage'] = Html::a('管理', ['admin/user/info', 'id'=>$user['id']], ['class'=>'super normal button']);
}
}
?>
<div class="box">
    <div class="cell">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td width="73" valign="top" align="center"><?php echo Html::img('@web/'.str_replace('{size}', 'large', $user['avatar']), ['class'=>'avatar','border'=>'0','align'=>'default']); ?><div class="sep5"></div><img src="/<?php echo SfHtml::uGroupRank($user['score']);?>" title="<?php echo SfHtml::uGroup($user['score']);?>" alt="<?php echo SfHtml::uGroup($user['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"> <span class="fade"><?php echo SfHtml::uGroup($user['score']);?></span></td>
            <td width="10"></td>
            <td width="auto" valign="top" align="left">
                <div class="fr" style="margin-top: 5px">
                   <?php echo implode(' ', $userOp); ?>
                </div>
                <h1 style="margin-bottom: 5px;"><?php echo Html::encode($user['username'])?></h1>
                <span class="bigger"><?php echo Html::encode($user['userInfo']['tagline'])?></span>
                <div class="sep10"></div>
                <span class="gray"><?php echo Html::encode($settings['site_name']);?> 第 <?php echo Html::encode($user['id'])?> 号会员，加入于 <?php echo $formatter->asDateTime($user['created_at'], 'y-MM-dd HH:mm:ss xxx')?></span>
            </td>
        </tr>
    </tbody></table>
    <div class="sep5"></div>
</div><?php if ($user['userInfo']['website']!=NULL) : ?>
    <div class="cell markdown_body">
<a href="<?php echo Html::encode($user['userInfo']['website'])?>" class="social_label" target="_blank" rel="nofollow"><img src="/static/images/social_home.png" width="24" alt="Website" align="absmiddle" /> &nbsp;<?php echo Html::encode($user['userInfo']['website'])?></a>
    </div><?php endif; ?>
    <?php if ($user['userInfo']['about']!=NULL) : ?>
<div class="cell"><?php echo $user['userInfo']['about'];?></div><?php endif; ?>
</div>
<div class="sep5"></div>
<div class="box">
    <div class="cell_tabs"><div class="fl"><?php echo Html::img('@web/'.str_replace('{size}', 'small', $user['avatar']), ['style'=>'border-radius: 24px; margin-top: -2px;','border' => '0'])?></div><?php echo Html::a(Html::encode($user['username']).' 创建的所有主题', ['user/view', 'username'=>Html::encode($user['username'])], ['class'=>'cell_tab_current'])?></div>
<?php if ($user['userInfo']['topic_close']==1){?>
<div class="inner"><table cellpadding="0" cellspacing="10" border="0" width="100%">
<tbody><tr>
    <td width="60" align="center"><img src="/static/images/lock256.png" border="0" width="58"></td>
    <td width="auto" align="left" class="topic_content"><span class="gray">根据 <?php echo Html::encode($user['username'])?> 的设置，主题列表被隐藏</span></td>
</tr>
</tbody></table></div>
<?php }else{ ?>
<?php if ($user['topics']!=NULL) : ?>
<?php
foreach($user['topics'] as $topic){
    $url = ['topic/view', 'id'=>$topic['id']];
    echo '<div class="cell item"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="24" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'small', $user['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($user['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="small fade">';if ($topic['vote_count']>0){echo '<div class="votes"><i class="iconfont icon-chevronup"></i> &nbsp;'.$topic['vote_count'].' &nbsp;&nbsp; </div>';}echo Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']],['class'=>'node']).' &nbsp;•&nbsp;  <strong>';echo Html::a(Html::encode($user['username']),['user/view', 'username'=>Html::encode($user['username'])]),'</strong><div class="sep5"></div> <span class="item_title">',Html::a(Html::encode($topic['title']), $url);if ($topic['alltop']==1){echo ' <i class="iconfont">&#xe610;</i>';}if ($topic['top']==1){echo ' <i class="iconfont">&#xe60e;</i>';}if ($topic['star']==1){echo ' <i class="iconfont">&#xe614;</i>';}if ($topic['comment_count']>10&&$topic['views']>300){echo ' <i class="iconfont">&#xe603;</i>';}echo '</span><div class="sep5"></div>',Yii::$app->formatter->asRelativeTime($topic['created_at']);if ($topic['comment_count']>0) {echo ' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['replied_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
    <div class="inner"><span class="chevron">»</span> <?php echo Html::a(Html::encode($user['username']).'创建的更多主题', ['topics', 'username'=>Html::encode($user['username'])]); ?></div>
<?php endif; ?>
<?php };?>
</div>
<div class="sep5"></div>
<div class="box">
<div class="cell"><span class="gray"><?php echo Html::encode($user['username'])?> 最近回复了</span></div>
<?php if ($user['userInfo']['comment_close']==1){?>
<div class="inner"><table cellpadding="0" cellspacing="10" border="0" width="100%">
<tbody><tr>
    <td width="60" align="center"><img src="/static/images/lock256.png" border="0" width="60"></td>
    <td width="auto" align="left" class="topic_content"><span class="gray">根据 <?php echo Html::encode($user['username'])?> 的设置，回复列表被隐藏</span></td>
</tr>
</tbody></table></div>
<?php }else{ ?>
<?php if ($user['comments']!=NULL) : ?>
<?php foreach($user['comments'] as $comment){?>
<?php $editorClass = '\app\plugins\\'. $comment['topic']['node']['editor']. '\\'. $comment['topic']['node']['editor'];
$editor = new $editorClass();?>
<div class="dock_area">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td style="padding: 10px 15px 8px 15px; font-size: 12px; text-align: left;"><div class="fr"><span class="fade"><?php echo $formatter->asRelativeTime($comment['created_at']);?></span></div><span class="gray">回复了 <?php echo Html::a(Html::encode($comment['topic']['author']['username']), ['user/view', 'username'=>Html::encode($comment['topic']['author']['username'])])?> 创建的主题 <span class="chevron">›</span> <?php echo Html::a(Html::encode($comment['topic']['title']), ['topic/view', 'id'=>$comment['topic_id']]);?></span></td> 
</tr>
<tr><td align="left"><img src="/static/images/arrow.png" style="margin-left: 20px;" /></td></tr>
</table>
</div>
<div class="cell">
<div class="reply_content view"><?php if ( $comment['invisible'] == 1 || $user['status'] == User::STATUS_BANNED ) {echo '<div class="outdated">此回复已被屏蔽</div>';if (!$isGuest && $me->isAdmin()) {echo $editor->parse($comment['content']);}} else {echo $editor->parse($comment['content']);};?></div>
</div>
<?php };?>
 <div class="inner"><span class="chevron">»</span> <?php echo Html::a(Html::encode($user['username']).' 创建的更多回复', ['comments', 'username'=>Html::encode($user['username'])]); ?></div>
 <?php endif; ?>
 <?php };?>
</div>
</div></div>
<script>
hljs.initHighlightingOnLoad();
</script>