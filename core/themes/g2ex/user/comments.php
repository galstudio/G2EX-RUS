<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\User;
\app\themes\g2ex\layouts\highlightAsset::register($this);
$currentPage = $pages->page+1;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($user['username']);
$this->metaTags[]='<meta name="keywords" content="'.Html::encode($user['username']).','.$settings['site_name'].'"/>';
if(empty($user['userInfo']['tagline'])){
    $this->metaTags[]='<meta name="Description" content="'.$settings['slogan'].'"/>';
}else{
$this->metaTags[]='<meta name="Description" content="'.Html::encode($user['username']).' : '.Html::encode($user['userInfo']['tagline']).' - '.$settings['slogan'].'"/>';
}
$title = Html::encode($settings['site_name']).' › '.Html::encode($user['username']).'在 '.$this->title.' 创建的回复';
$formatter = Yii::$app->getFormatter();
$isGuest = Yii::$app->getUser()->getIsGuest();
if (!$isGuest) {
    $me = Yii::$app->getUser()->getIdentity();
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php if ($user['userInfo']['topic_close']==0){?><div class="fr f12"><span class="snow">回复总数&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?php };?><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a(Html::encode($user['username']),['user/view', 'username'=>Html::encode($user['username'])]); ?> <span class="chevron">&nbsp;›&nbsp;</span> 全部回复第 <?=$currentPage;?> 页 / 共 <?=$pages->pagecount;?> 页</div>
<?php if ($user['userInfo']['comment_close']==1){?>
<div class="inner"><table cellpadding="0" cellspacing="10" border="0" width="100%">
<tbody><tr>
    <td width="200" align="center"><img src="/static/images/lock256.png" border="0" width="128"></td>
    <td width="auto" align="left" class="topic_content"><span class="gray">根据 <?=Html::encode($user['username'])?> 的设置，回复列表被隐藏</span></td>
</tr>
</tbody></table></div>
<?php }else{ ?>
<?php foreach($comments as $comment){?>
<?php $editorClass = '\app\plugins\\'. $comment['topic']['node']['editor']. '\\'. $comment['topic']['node']['editor'];
$editor = new $editorClass();?>
<div class="dock_area">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td style="padding: 10px 15px 8px 15px; font-size: 12px; text-align: left;"><div class="fr"><span class="fade"><?=$formatter->asRelativeTime($comment['created_at']);?></span></div><span class="gray">回复了 <?=Html::a(Html::encode($comment['topic']['author']['username']), ['user/view', 'username'=>Html::encode($comment['topic']['author']['username'])])?> 创建的主题 <span class="chevron">›</span> <?=Html::a(Html::encode($comment['topic']['title']), ['topic/view', 'id'=>$comment['topic_id']]);?></span></td> 
</tr>
<tr><td align="left"><img src="/static/images/arrow.png" style="margin-left: 20px;" /></td></tr>
</table>
</div>
<div class="cell">
<div class="reply_content view"><?php if ( $comment['invisible'] == 1 || $user['status'] == User::STATUS_BANNED ) {echo '<div class="outdated">此回复已被屏蔽</div>';if (!$isGuest && $me->isAdmin()) {echo $editor->parse($comment['content']);}} else {echo $editor->parse($comment['content']);};?></div>
</div>
<?php };?>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php };?>
<?php };?>
</div>
</div>
<script>
hljs.initHighlightingOnLoad();
</script>
