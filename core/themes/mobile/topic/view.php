<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\Helper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use app\components\SfHtml;
use app\models\User;
use app\models\Favorite;
use app\models\History;
use app\models\Topic;
use app\models\Siteinfo;
\app\themes\g2ex\layouts\highlightAsset::register($this);
\app\themes\g2ex\layouts\autosizeAsset::register($this);
\app\assets\LightboxAsset::register($this);
$siteinfo = Siteinfo::getSiteInfo();
$settings = Yii::$app->params['settings'];
$request = Yii::$app->getRequest();
$formatter = Yii::$app->getFormatter();
$currentPage = $pages->page+1;
$editorClass = '\app\plugins\\'. $topic['node']['editor']. '\\'. $topic['node']['editor'];
$editor = new $editorClass();
$editorClass1 = '\app\plugins\\'. $topic['editor'].'\\'. $topic['editor'];
$editor1 = new $editorClass1();
$editor->registerAsset($this);
$indexUrl = ['topic/index'];
$nodeUrl = ['topic/node', 'name'=>$topic['node']['ename']];
$topicUrl = ['topic/edit', 'id'=>$topic['id']];
$isGuest = Yii::$app->getUser()->getIsGuest();
$me = Yii::$app->getUser()->getIdentity();
if(!$isGuest){
     if( $topic['comment_closed']==0){
if(!$me->isWatingActivation()){
\app\themes\g2ex\layouts\emojiAsset::register($this);
}
}}
$topicOp = [];
if(!$isGuest) {
    $me = Yii::$app->getUser()->getIdentity();
    if ( $me->canEdit($topic) ) {
        $topicOp['edit'] = Html::a('EDIT', $topicUrl,['class'=>'op']);
    }
    if ($me->isAdmin()) {
         $topicUrl[0] = 'admin/topic/change-node';
        $topicOp['changeNode'] = Html::a('MOVE', $topicUrl,['class'=>'op']);
        $topicUrl[0] = 'admin/topic/delete';
        $topicOp['delete'] = Html::a('DELETE', $topicUrl, [
            'class'=>'op',
            'data' => [
                'confirm' => '注意：删除后将不会恢复！确认删除！',
                'method' => 'post',
            ]]);
    }
}
$userOp = [];
if(!$isGuest && $me->isActive()) {
     $userOp['vote'] = Favorite::checkFollow($me->id, Favorite::TYPE_VOTE_TOPIC, $topic['id'])?Html::a('<i class="iconfont icon-chevrondown"></i>' .($topic['vote_count']>0?'<span class="favorite-num nbsp">'.$topic['vote_count']. '</span>':'<span class="favorite-num"></span>'), null, ['class'=>'favorite vote', 'title'=>'取消赞', 'href' => 'javascript:void(0);', 'params'=>'unfavorite vote_topic '. $topic['id']]):Html::a('<i class="iconfont icon-chevronup"></i>' . ($topic['vote_count']>0?'<span class="favorite-num nbsp">'.$topic['vote_count']. '</span>':'<span class="favorite-num"></span>'), null, ['class'=>'favorite vote', 'title'=>'赞', 'href' => 'javascript:void(0);', 'params'=>'favorite vote_topic '. $topic['id']]);
    $userOp['topic'] = History::checkThank($me->id, History::ACTION_GOOD_TOPIC, $topic['id'])?'<span class="thanks f11 gray" style="text-shadow: 0px 1px 0px #fff;">感谢已发送</span>':Html::a('感谢', null, ['id'=>'good-topic-'.$topic['id'],'class'=>'topic_thank op','href' => 'javascript:void(0);']);
    $userOp['follow'] = Favorite::checkFollow($me->id, Favorite::TYPE_TOPIC, $topic['id'])?Html::a('<span class="favorite-name">取消收藏</span>', null, ['class'=>'favorite op', 'title'=>'取消收藏', 'href' => 'javascript:void(0);', 'params'=>'unfavorite topic '. $topic['id']]):Html::a('<span class="favorite-name">加入收藏</span>', null, ['class'=>'favorite op', 'title'=>'加入收藏', 'href' => 'javascript:void(0);', 'params'=>'favorite topic '. $topic['id']]);
} 
$this->title = Html::encode($topic['title']).' - '.Html::encode($settings['site_name']);
?>
<div class="box" style="border-bottom: 0px;">
    <div class="header"><div class="fr" style="margin-right: 5px;"><?=Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align'=>'default' ,'style'=>'max-width: 36px; max-height: 36px;']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]); ?><div class="sep5"></div> <span class="fade f12"><img src="/<?=SfHtml::uGroupRank($topic['author']['score']);?>"  alt="<?=SfHtml::uGroup($topic['author']['score']);?>" title="<?=SfHtml::uGroup($topic['author']['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"> <?=SfHtml::uGroup($topic['author']['score']);?></span></div>
    <?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?= Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']]); ?>
    <div class="sep5"></div>
   <h1><?=Html::encode($topic['title']);?></h1>
    <small class="gray">By <?=Html::a(Html::encode($topic['author']['username']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]);?> at <?=$formatter->asRelativeTime($topic['created_at']); ?>, <?=Html::encode($topic['views']); ?> 次点击&nbsp;<?php if (!$isGuest){  if ( !empty($topicOp) ) {echo implode('&nbsp;', $topicOp);};}?></small>
    </div>
<?php if($topic['star']==1){?><div class="message"> <i class="iconfont icon-zuanshi red"></i> 此主题已被设为精华贴！</div><?php }?>
<?php if($topic['comment_closed']==1){?><div class="problem">此主题已锁定，无法回复！</div><?php }?>
<?php
 if(!empty($topic['content']['content'])) {
            $topicShow = true;
            if ( intval($topic['invisible']) === 1 || intval($topic['author']['status']) === User::STATUS_BANNED ) {
                echo '<div class="outdated">此主题已被屏蔽</div>';
                $topicShow = false;
            }
            if ( intval($topic['access_auth']) === Topic::TOPIC_ACCESS_REPLY
                    && !$isGuest && !$me->isAuthor($topic['user_id']) && !$me->hasReplied($topic['id']) ) {
                echo '<div class="problem">此主题需要回复才能查看</div>';
                $topicShow = false;
            }
            if ( $topicShow === true || !$isGuest && $me->isAdmin() ) {
                echo '<div class="cell"><div class="topic_content img-zoom"><div class="markdown_body">',$editor1->parse($topic['content']['content']),'</div></div></div>';
            }
        }
?>
<div class="inner gray f11" style="line-height: 12px; padding-top: 3px; text-shadow: 0px 1px 0px #fff;"><?php if($topic['favorite_count']>0){echo Html::encode($topic['favorite_count']).' 人收藏 &nbsp; ';}; ?>
<?php if (!$isGuest){ echo $userOp['follow'],'&nbsp;';}?>&nbsp;<a href="javascript:;" onclick="window.open('http://service.weibo.com/share/share.php?url=<?=Yii::$app->request->absoluteUrl?>&amp;appkey=3319322358&amp;<?php if ( !$isGuest){echo 'r='.$me->username;}?>&amp;title=<?=Html::encode($topic['title'])?>', '_blank', 'width=550,height=370'); recordOutboundLink(this, 'Share', 'weibo.com');" class="op" title="分享到微博">Weibo</a>&nbsp;&nbsp;<a href="javascript:;" class="op" data-pop="weixin" title="分享到微信">Wechat</a>&nbsp;&nbsp;<div id="topic_thank"><?php if (!$isGuest){ echo $userOp['topic'];};?></div></div>
</div>
<div class="sep5"></div>
<?php if($topic['comment_count']==0){?>
<?php if($topic['comment_closed']==0){?>
<div class="sep5"></div>
<div class="box transparent"><div class="inner" style="text-align: center"><span style="color:#666;">目前尚无回复</span></div>
</div>
<div class="sep5"></div><?php }; ?>
<?php if( !empty($topic['tags']) ) {
echo '<div class="box"><div class="inner">';
$tags = explode(',', strtolower($topic['tags']));foreach($tags as $tag) {echo Html::a(Html::encode($tag), ['tag/index', 'name'=>$tag], ['class'=>'tag']);}echo '</div></div>';}?>
<?php }else{?>
<div class="box">
<div class="cell">
    <span class="gray"><?=$topic['comment_count'], '&nbsp;回复&nbsp;<strong class="snow">|</strong>&nbsp;直到&nbsp;', 
	$formatter->asDateTime($topic['replied_at'], 'y-MM-dd HH:mm:ss xxx') ?></span>
</div>
<?php foreach($comments as $comment){?>
	<div id="reply<?=$comment['position']?>" class="cell">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tbody><tr>
	<td width="24" valign="top"><?=Html::img('@web/'.str_replace('{size}', 'small', $comment['author']['avatar']), ['class'=>'avatar','border'=>'0','align'=>'default','style'=>'max-width: 24px; max-height: 24px;margin-bottom:5px;'])?><br><?=Html::a('私信', ['service/sms', 'to'=>Html::encode($comment['author']['username'])], ['title' => '私信TA','class'=>'thank','target'=>'_blank']);?></td>
	<td width="10" valign="top"></td>
	<td width="auto" valign="top" align="left"><div class="fr">
 <?php if ( !$isGuest ) {?>
                <div id="thank_area_<?=$comment['id']?>" class="thank_area">
                   <?php if (!$isGuest){ echo History::checkThank($me->id, History::ACTION_GOOD_COMMENT, $comment['id'])?'<div class="thanked">感谢已发送</div>':Html::a('感谢回复者', null, ['id'=>'good-comment-'.$comment['id'],'class'=>'comment_thank thank','href' => 'javascript:void(0);']);};?>
                </div> 
                <?php if ( $me->canReply($topic) ) {
                echo Html::a('<img src="/static/images/reply.png" align="absmiddle" border="0" alt="Reply" />', null, ['href' => 'javascript:replyTo("'. Html::encode($comment['author']['username']) .'");']), '  ';
                }?>
                <?php ;}?>
	<span class="no"><?=$comment['position']?></span></div>
	<div class="sep3"></div>
	<strong><?=Html::a(Html::encode($comment['author']['username']), ['user/view', 'username'=>Html::encode($comment['author']['username'])])?></strong>&nbsp;<img src="/<?=SfHtml::uGroupRank($comment['author']['score']);?>"  alt="<?=SfHtml::uGroup($comment['author']['score']);?>" title="<?=SfHtml::uGroup($comment['author']['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px;margin-bottom: 4px">&nbsp;<span class="fade small"><?=$formatter->asRelativeTime($comment['created_at'])?>&nbsp;<?=Html::encode($comment['good'])>0?'<span class="small fade">♥ '.Html::encode($comment['good']).'</span>':''?></span>
	<div class="sep5"></div>
	<div class="reply_content rc img-zoom">
		<?php if ( $comment['invisible'] == 1 || $comment['author']['status'] == User::STATUS_BANNED ) {
		echo '<div class="outdated">此回复已被屏蔽</div>';
		if (!$isGuest && $me->isAdmin()) {
		echo $editor->parse($comment['content']);
		}
		} else {
		echo $editor->parse($comment['content']);
		}?>
	</div>
	 <div class="fr">
                <?php if (!$isGuest){?>
                <?php $commentUrl = ['comment/edit', 'id'=>$comment['id']];
                    if ( $me->canEdit($comment, $topic['comment_closed']) ) {
                    echo Html::a('修改', $commentUrl,['class'=>'thank gray']), ' &nbsp; ';}
                    if ( $me->isAdmin() ) {
                    $commentUrl[0] = 'admin/comment/delete';
                    echo Html::a('删除', $commentUrl, ['class'=>'thank gray','data' => ['confirm' => '注意：删除后将不会恢复！确认删除！','method' => 'post',]]), ' &nbsp; ';
                   }?>
                <?=Favorite::checkFollow($me->id, Favorite::TYPE_VOTE_COMMENT, $comment['id'])?Html::a(($comment['vote_count']>0?'<span class="favorite-num red">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 cur"></i>', null, ['class'=>'favorite', 'title'=>'取消赞', 'href' => 'javascript:void(0);', 'params'=>'unfavorite vote_comment '. $comment['id']]):Html::a(($comment['vote_count']>0?'<span class="favorite-num fade">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 fade"></i>' , null, ['class'=>'favorite', 'title'=>'赞', 'href' => 'javascript:void(0);', 'params'=>'favorite vote_comment '. $comment['id']]);}else{echo Html::a(($comment['vote_count']>0?'<span class="favorite-num fade">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 fade"></i>' , ['site/login'],['class'=>'favorite']);?>
                <?php  };?>
            </div>
	</td>
	</tr>
	</tbody></table>
	</div>
<?php ;}?>
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
<?php ;}?>
<?php if( !$isGuest && $me->canReply($topic) ): ?>
<div class="sep5"></div>
<div class="box">
    <div class="cell"><div class="fr"><a href="#"><strong>↑</strong> 回到顶部</a></div>
        添加一条新回复 <span class="emotion">&nbsp;</span>
    </div>
    <div class="cell rc"><?php $form = ActiveForm::begin(['id'=>'new' ,'action' => ['comment/reply', 'id'=>$topic['id']]]);
	echo $form->field(new \app\models\Comment(), 'content')->textArea(['id'=>'editor','class'=>'mll'])->label(false);?>
        <div class="sep5"></div>
        <?=Html::submitButton('添加回复', ['class' => 'super normal button']); ?>
       <div id="fileuploader">图片上传</div>
<?php if($me->canUpload($settings)) {$editor->registerUploadAsset($this);}?>
<?php ActiveForm::end(); ?>
    </div>
</div>
<?php endif; ?>
</div></div>
<script>
hljs.initHighlightingOnLoad();
autosize(document.querySelectorAll('textarea'));
</script>
<?php if ($topic['node']['image']!=NULL) : ?>
<style type="text/css">
<?=Html::encode($topic['node']['image'])?>
</style>
<?php endif; ?>