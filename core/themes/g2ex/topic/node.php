<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Topic;
use app\models\User;
use app\models\Favorite;
use app\models\Node;
use app\models\Siteinfo;
use app\models\Ad;
use yii\widgets\ActiveForm;
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$siteinfo = Siteinfo::getSiteInfo();
$formatter = Yii::$app->getFormatter();
$settings = Yii::$app->params['settings'];
$isGuest = Yii::$app->getUser()->getIsGuest();
$me = Yii::$app->getUser()->getIdentity();
$currentPage = $pages->page+1;
if (!$isGuest && $me->isActive()) {
    $follow = Favorite::checkFollow($me->id, Favorite::TYPE_NODE, $node['id'])?' <span class="snow">&nbsp;•&nbsp;</span> '.Html::a('<span class="favorite-name">Удалить из избранного</span>', null, ['class'=>'favorite', 'title'=>'Из избранного', 'href' => 'javascript:void(0);', 'params'=>'unfavorite node '. $node['id']]):' <span class="snow">&nbsp;•&nbsp;</span> '.Html::a('<span class="favorite-name">В избранное</span>', null, ['class'=>'favorite', 'title'=>'В избранное', 'href' => 'javascript:void(0);', 'params'=>'favorite node '. $node['id']]);
} else {
    $follow = '';
}
$editorClass = '\app\plugins\\'. $node['editor']. '\\'. $node['editor'];
$editor = new $editorClass();
$editor->registerAsset($this);
if(!$isGuest){
\app\themes\g2ex\layouts\emojiAsset::register($this);
}
$this->title = Html::encode($settings['site_name']) . ' › '.Html::encode($node['name']) ;
$title = Html::encode($node['ename']);
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/mynode'); ?>
<?php
$ads = Ad::getAds();
if( !empty($ads) ):
foreach($ads as $ad) {if ($formatter->asDateTime(time(), 'dd.MM.y') < $ad['expires']){ if ($ad['node_id']==$node['id']||$ad['node_id']==1){?>
<div class="sep20"></div>
<div class="box">
<?=$ad['content']?>
</div>
<?php }}} endif;?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php if ($node['icon']!=NULL) : ?><div style="float: left; display: inline-block; margin-right: 10px; margin-bottom: initial!important;"><img src="/<?=Html::encode($node['icon']); ?>" border="0" align="default" width="auto"></div><?php endif; ?><div class="fr f12"><span class="snow">Топиков</span> <strong class="gray"><?=Html::encode($node['topic_count']); ?></strong><?=$follow;?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::encode($node['name']); ?>
    <div class="sep10"></div>
    <span class="f12 gray"><?=Html::encode($node['about']); ?></span>
    <div class="sep10"></div>
    <?php if (!Yii::$app->getUser()->getIsGuest() && Yii::$app->getUser()->getIdentity()->status >= User::STATUS_ACTIVE ) {?>
<input type="button" class="super normal button" value="Создать топик" onclick="location.href = '<?='/new/'.$node['ename'];?>';"><?php ;}?>
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
<?php };?>
<?php
foreach($topics as $topic){
    $topic = $topic['topic'];
    $url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1 || $topic['top']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="48" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo '</span><div class="sep5"></div><span class="small fade">';if ($topic['vote_count']>0){echo '<div class="votes"><i class="iconfont icon-chevronup"></i> &nbsp;'.$topic['vote_count'].' &nbsp;&nbsp; </div>';}echo '<strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['created_at']);if ($topic['comment_count']>0) {echo ' &nbsp;•&nbsp; Последний комментарий от <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong> &nbsp;•&nbsp; ',Yii::$app->formatter->asRelativeTime($topic['replied_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
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
<?php };?>
</div>
<?php if( !$isGuest && Yii::$app->getUser()->getIdentity()): ?>
<div class="sep20"></div>
<div class="box" style="overflow: hidden;">
    <div class="cell rc" style="overflow: hidden;">
    <?php $form = ActiveForm::begin(['id'=>'new' ,'action' => ['topic/add', 'node'=>$node['ename']]]);?>
    <?=$form->field(new \app\models\topic(), 'editor')->hiddenInput(['value'=>$node['editor']])->label(false);?>
    <?=$form->field(new \app\models\topic(), 'title')->textArea(['rows' => '1','placeholder'=>'Введите название топика, если он может отразить полное содержание, текст может быть пустым','class'=>'sll','maxlength'=>120,'style'=>'resize: none;'])->label(false); ?>
        <div class="sep10"></div>
    <?=$form->field(new \app\models\TopicContent(), 'content')->textArea(['id'=>'editor','class'=>'mll','placeholder'=>'Текст' ,'style'=>'overflow: hidden; word-wrap: break-word; resize: none; height: 112px;'])->label(false);?>
<div class="sep10"></div>
        <?=Html::submitButton('Создать топик', ['class' => 'super normal button']); ?> <span class="emotion">&nbsp;</span>
       <div id="fileuploader">Текст топика</div>
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
<?php if ($node['image']!=NULL) : ?>
<style type="text/css">
<?=Html::encode($node['image'])?>
</style>
<?php endif; ?>
<script>
autosize(document.querySelectorAll('textarea'));
</script>
