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
use app\models\Ad;
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
        $topicOp['edit'] = Html::a('ПРАВКА', $topicUrl,['class'=>'op']);
    }
    if ($me->isAdmin()) {
         $topicUrl[0] = 'admin/topic/change-node';
        $topicOp['changeNode'] = Html::a('ПЕРЕМЕСТИТЬ', $topicUrl,['class'=>'op']);
        $topicUrl[0] = 'admin/topic/delete';
        $topicOp['delete'] = Html::a('УДАЛИТЬ', $topicUrl, [
            'class'=>'op',
            'data' => [
                'confirm' => 'Примечание: После удаления восстанавление невозможно! Подтвердить удаление!',
                'method' => 'post',
            ]]);
    }
}
$userOp = [];
if(!$isGuest && $me->isActive()) {
     $userOp['vote'] = Favorite::checkFollow($me->id, Favorite::TYPE_VOTE_TOPIC, $topic['id'])?Html::a('<i class="iconfont icon-chevrondown"></i>' .($topic['vote_count']>0?'<span class="favorite-num nbsp">'.$topic['vote_count']. '</span>':'<span class="favorite-num"></span>'), null, ['class'=>'favorite vote', 'title'=>'Не нравится', 'href' => 'javascript:void(0);', 'params'=>'unfavorite vote_topic '. $topic['id']]):Html::a('<i class="iconfont icon-chevronup"></i>' . ($topic['vote_count']>0?'<span class="favorite-num nbsp">'.$topic['vote_count']. '</span>':'<span class="favorite-num"></span>'), null, ['class'=>'favorite vote', 'title'=>'赞', 'href' => 'javascript:void(0);', 'params'=>'favorite vote_topic '. $topic['id']]);
    $userOp['topic'] = History::checkThank($me->id, History::ACTION_GOOD_TOPIC, $topic['id'])?'<span class="thanks f11 gray" style="text-shadow: 0px 1px 0px #fff;">Отправлено</span>':Html::a('Спасибо', null, ['id'=>'good-topic-'.$topic['id'],'class'=>'topic_thank tb','href' => 'javascript:void(0);']);
    $userOp['follow'] = Favorite::checkFollow($me->id, Favorite::TYPE_TOPIC, $topic['id'])?Html::a('<span class="favorite-name">Из избранного</span>', null, ['class'=>'favorite tb', 'title'=>'Из избранного', 'href' => 'javascript:void(0);', 'params'=>'unfavorite topic '. $topic['id']]):Html::a('<span class="favorite-name">В избранное</span>', null, ['class'=>'favorite tb', 'title'=>'В избранное', 'href' => 'javascript:void(0);', 'params'=>'favorite topic '. $topic['id']]);
}
$this->title = Html::encode($topic['title']).' - '.Html::encode($settings['site_name']);
if( !empty($topic['tags']) ) {
$this->metaTags[]='<meta name="keywords" content="'.Html::encode($topic['tags']).','.Html::encode($topic['title']).','.$settings['site_name'].'"/>';
}else{
$this->metaTags[]='<meta name="keywords" content="'.Html::encode($topic['title']).','.$settings['site_name'].'"/>';
}
$this->metaTags[]='<meta name="Description" content="'.Helper::truncate_utf8_string($editor->parse($topic['content']['content']),100,false).' - '.$settings['slogan'].'"/>';
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/mynode'); ?>
<?php
$ads = Ad::getAds();
if( !empty($ads) ):
foreach($ads as $ad) {if ($formatter->asDateTime(time(), 'dd.MM.y') < $ad['expires']){ if ($ad['node_id']==$topic['node']['id']||$ad['node_id']==1){?>
<div class="sep20"></div>
<div class="box">
<?=$ad['content']?>
</div>
<?php }}} endif;?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box" style="border-bottom: 0px;">
    <div class="header"><div class="fr"><?=Html::a(Html::img('@web/'.str_replace('{size}', 'large', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align'=>'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]); ?><div class="sep5"></div> <span class="fade f12"><img src="/<?=SfHtml::uGroupRank($topic['author']['score']);?>"  alt="<?=SfHtml::uGroup($topic['author']['score']);?>" title="<?=SfHtml::uGroup($topic['author']['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"> <?=SfHtml::uGroup($topic['author']['score']);?></span></div>
    <?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?= Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']]); ?>
    <div class="sep10"></div>
    <h1><?=Html::encode($topic['title']);?></h1>
<div class="votes">
<?php if (!$isGuest){ echo $userOp['vote'];};?>
</div>&nbsp;
    <small class="gray"><?=Html::a(Html::encode($topic['author']['username']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]);?> · <?=$formatter->asRelativeTime($topic['created_at']); ?> · <?=Html::encode(Yii::t('app', '{n, plural, one{# просмотр} few{# просмотра} many{# просмотров} other{# просмотры}}', ['n' => $topic['views']])); ?> &nbsp; <?php if (!$isGuest){  if ( !empty($topicOp) ) {echo implode('&nbsp;&nbsp;', $topicOp);};}?>
    </small>
    </div>
<?php if($topic['star']==1){?><div class="message" onclick="$(this).slideUp('fast');"> <i class="iconfont red">&#xe614;</i> Этот топик отмечен, как интересный!</div><?php }?>
<?php if(time()-$topic['created_at']>2592000){?><div class="outdated" onclick="$(this).slideUp('fast');">Эта Этот то создан <?=$formatter->asRelativeTime($topic['created_at']);?> и информация в нем могла быть обновлена или изменена.</div><?php }?>
<?php if($topic['comment_closed']==1){?><div class="outdated">В этом топике комментарии отключены!</div><?php }?>
<?php
 if(!empty($topic['content']['content'])) {
            $topicShow = true;
            if ( intval($topic['invisible']) === 1 || intval($topic['author']['status']) === User::STATUS_BANNED ) {
                echo '<div class="outdated">Содержание этого топика скрыто.</div>';
                $topicShow = false;
            }
            if ( intval($topic['access_auth']) === Topic::TOPIC_ACCESS_REPLY
                    && !$isGuest && !$me->isAuthor($topic['user_id']) && !$me->hasReplied($topic['id']) ) {
                echo '<div class="problem">Вы должны добавить комментарий для просмотра этого топика.</div>';
                $topicShow = false;
            }
            if ( $topicShow === true || !$isGuest && $me->isAdmin() ) {
                echo '<div class="cell link-external"><div class="topic_content img-zoom"><div class="markdown_body">',$editor1->parse($topic['content']['content']),'</div></div></div>';
            }
        }
?>
<div class="topic_buttons"><div class="fr gray f11" style="line-height: 12px; padding-top: 3px; text-shadow: 0px 1px 0px #fff;"><?=Html::encode(Yii::t('app', '{n, plural, one{# просмотр} few{# просмотра} many{# просмотров} other{# просмотры}}', ['n' => $topic['views']])); ?> <?php if($topic['favorite_count']>0){echo '&nbsp;∙&nbsp;'.Html::encode($topic['favorite_count']).' в избранном';}; ?> &nbsp; </div>
<?php if (!$isGuest){ echo $userOp['follow'];}?>&nbsp;
<a href="javascript:;" onclick="window.open('http://twitter.com/home?status=<?=Html::encode($topic['title'])?>: <?=Yii::$app->request->absoluteUrl?>', '_blank', 'width=550,height=370'); recordOutboundLink(this, 'Share', 'weibo.com');" class="tb" title="поделиться в Twitter">Twitter</a>&nbsp;<a href="javascript:;" class="tb" data-pop="weixin" title="QR код">QR код</a>&nbsp;
<div id="topic_thank"><?php if (!$isGuest){ echo $userOp['topic'];};?></div>
</div>
</div>
<div class="sep20"></div>
<?php if($topic['comment_count']==0){?>
<?php if($topic['comment_closed']==0){?>
    <div class="box transparent"><div class="inner" style="text-align: center"><span style="color:#666;">Здесь пока нет комментариев</span></div>
    </div>
    <div class="sep20"></div><?php }; ?>
    <?php if( !empty($topic['tags']) ) {
    echo '<div class="box"><div class="inner">';
    $tags = explode(',', strtolower($topic['tags']));foreach($tags as $tag) {echo Html::a(Html::encode($tag), ['tag/index', 'name'=>$tag], ['class'=>'tag']);}echo '</div></div>';}?>

<?php }else{?>
    <div class="box">
    <div class="cell"><div class="fr" style="margin: -3px -5px 0px 0px;">
    <?php if( !empty($topic['tags']) ) {
    $tags = explode(',', strtolower($topic['tags']));foreach($tags as $tag) {echo Html::a(Html::encode($tag), ['tag/index', 'name'=>$tag], ['class'=>'tag']);}}?></div>
        <span class="gray"><?=Yii::t('app', '{n, plural, one{# комментарий} few{# комментария} many{# комментариев} other{# комментариев}}', ['n' => $topic['comment_count']]).'&nbsp;<strong class="snow">|</strong>&nbsp;добавлен&nbsp;',
        $formatter->asDateTime($topic['replied_at'], 'dd.MM.y HH:mm:ss xxx') ?></span>
    </div>
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
        <?php ;}?>
       <?php foreach($comments as $comment){?>
            <div id="reply<?=$comment['position']?>" class="cell">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tbody><tr>
            <td width="48" valign="top" align="center"><?=Html::img('@web/'.str_replace('{size}', 'normal', $comment['author']['avatar']), ['class'=>'avatar','border'=>'0','align'=>'default'], ['class'=>'media-left item-avatar'])?></td>
            <td width="10" valign="top"></td>
            <td width="auto" valign="top" align="left"><div class="fr">
                <?php if ( !$isGuest ) {?>
                <?=Html::a('ПС', ['service/sms', 'to'=>Html::encode($comment['author']['username'])], ['title' => 'ПС','class'=>'thank','target'=>'_blank']);?>
                <div id="thank_area_<?=$comment['id']?>" class="thank_area">
                   <?php if (!$isGuest){ echo History::checkThank($me->id, History::ACTION_GOOD_COMMENT, $comment['id'])?'<div class="thanked">Отправлено</div>':Html::a('Оценить', null, ['id'=>'good-comment-'.$comment['id'],'class'=>'comment_thank thank','href' => 'javascript:void(0);']);};?>
                </div> &nbsp;
                <?php if ( $me->canReply($topic) ) {
                echo Html::a('<img src="/static/images/reply.png" align="absmiddle" border="0" alt="Reply" />', null, ['href' => 'javascript:replyTo("'. Html::encode($comment['author']['username']) .'");']), '  ';
                }?> &nbsp;&nbsp;
                <?php ;}?>
            <span class="no"><?=$comment['position']?></span></div>
            <div class="sep3"></div>
            <strong><?=Html::a(Html::encode($comment['author']['username']), ['user/view', 'username'=>Html::encode($comment['author']['username'])])?></strong>&nbsp;<img src="/<?=SfHtml::uGroupRank($comment['author']['score']);?>"  alt="<?=SfHtml::uGroup($comment['author']['score']);?>" title="<?=SfHtml::uGroup($comment['author']['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px">&nbsp;<span class="fade small"><?=Html::encode($comment['author']['userInfo']['tagline']);?>&nbsp;&nbsp;<?=$formatter->asRelativeTime($comment['created_at'])?>&nbsp;&nbsp;<?=Html::encode($comment['good'])>0?'<span class="small fade">♥ '.Html::encode($comment['good']).'</span>':''?></span>
            <div class="sep5"></div>
            <div class="reply_content img-zoom">
                <?php if ( $comment['invisible'] == 1 || $comment['author']['status'] == User::STATUS_BANNED ) {
                echo '<div class="outdated">Этот комментарий был заблокирован</div>';
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
                    echo Html::a('Правка', $commentUrl,['class'=>'thank gray']), ' &nbsp; ';}
                    if ( $me->isAdmin() ) {
                    $commentUrl[0] = 'admin/comment/delete';
                    echo Html::a('Удалить', $commentUrl, ['class'=>'thank gray','data' => ['confirm' => 'Примечание: После удаления восстановление невозможно! Подтвердить удаление!','method' => 'post',]]), ' &nbsp; ';
                   }?>&nbsp;
                <?=Favorite::checkFollow($me->id, Favorite::TYPE_VOTE_COMMENT, $comment['id'])?Html::a(($comment['vote_count']>0?'<span class="favorite-num red">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 cur"></i>', null, ['class'=>'favorite', 'title'=>'Не нравится', 'href' => 'javascript:void(0);', 'params'=>'unfavorite vote_comment '. $comment['id']]):Html::a(($comment['vote_count']>0?'<span class="favorite-num fade">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 fade"></i>' , null, ['class'=>'favorite', 'title'=>'Нравится', 'href' => 'javascript:void(0);', 'params'=>'favorite vote_comment '. $comment['id']]);}else{echo Html::a(($comment['vote_count']>0?'<span class="favorite-num fade">'.$comment['vote_count']. '</span>':'<span class="favorite-num"></span>').' <i class="iconfont icon-zan f14 fade"></i>' , ['site/login'],['class'=>'favorite']);?>
                <?php  };?>
            </div>
            </td>
            </tr>
            </tbody></table>
            </div>
        <?php ;}?>
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
        <?php ;}?>
        </div>
<?php ;}?>
<?php if( !$isGuest && $me->canReply($topic) ): ?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><div class="fr"><a href="#"><strong>↑</strong> Вверх</a></div>
        Добавить комментарий <span class="emotion">&nbsp;</span>
    </div>
    <div class="cell rc"><?php $form = ActiveForm::begin(['action' => ['comment/reply', 'id'=>$topic['id']]]);
    echo $form->field(new \app\models\Comment(), 'content')->textArea(['id'=>'editor','class'=>'mll'])->label(false);?>
        <div class="sep10"></div>
        <?=Html::submitButton('Ответить', ['class' => 'super normal button']); ?>
       <div id="fileuploader">&nbsp;</div>
<?php if($me->canUpload($settings)) {$editor->registerUploadAsset($this);}?>
<?php ActiveForm::end(); ?>
    </div>
    <div class="inner">
        <div class="fr"><?=Html::a('← '.Html::encode($settings['site_name']), ['/']); ?></div>
        &nbsp;
    </div>
</div>
<?php endif; ?>
</div>
<?php SfHtml::afterAllPosts($this); ?>
<script>
hljs.initHighlightingOnLoad();
autosize(document.querySelectorAll('textarea'));
</script>
<?php if ($topic['node']['image']!=NULL) : ?>
<style type="text/css">
<?=Html::encode($topic['node']['image'])?>
</style>
<?php endif; ?>
<div class="pop" id="weixin" style="display:none;">
<div class="pop-wp"><a href="#" rel="nofollow" title="关闭" class="pop-close fr">×</a>
<div class="pop-title">QR код:</div>
<img  width="185" height="185" src="<?= Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])?>">
<div class="pop-foot">просканируйте этот QR код,<br>полученной ссылкой можете поделиться с друзьями</div>
</div>
</div>
