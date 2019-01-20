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
use yii\widgets\ActiveForm;
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$siteinfo = Siteinfo::getSiteInfo();
$formatter = Yii::$app->getFormatter();
$settings = Yii::$app->params['settings'];
$isGuest = Yii::$app->getUser()->getIsGuest();
$me = Yii::$app->getUser()->getIdentity();
$currentPage = $pages->page+1;
if (!$isGuest && $me->isActive()) {
    $follow = Favorite::checkFollow($me->id, Favorite::TYPE_NODE, $node['id'])?' <span class="snow">&nbsp;•&nbsp;</span> '.Html::a('<span class="favorite-name">取消收藏</span>', null, ['class'=>'favorite', 'title'=>'取消收藏', 'href' => 'javascript:void(0);', 'params'=>'unfavorite node '. $node['id']]):' <span class="snow">&nbsp;•&nbsp;</span> '.Html::a('<span class="favorite-name">加入收藏</span>', null, ['class'=>'favorite', 'title'=>'加入收藏', 'href' => 'javascript:void(0);', 'params'=>'favorite node '. $node['id']]);
} else {
    $follow = '';
}
$this->title = Html::encode($settings['site_name']) . ' › '.Html::encode($node['name']) ;
$title = Html::encode($node['ename']);
?>
<div class="box">
<div class="header"><div class="fr f12"><span class="snow">主题总数</span> <strong class="gray"><?=Html::encode($node['topic_count']); ?></strong><?=$follow;?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::encode($node['name']); ?>
    <div class="sep5"></div>
    <?php if (!Yii::$app->getUser()->getIsGuest() && Yii::$app->getUser()->getIdentity()->status >= User::STATUS_ACTIVE ) {?>
<input type="button" class="super normal button" value="创建新主题" onclick="location.href = '<?='/new/'.$node['ename'];?>';" style="width: 100%; line-height: 20px"><?php ;}?>
    </div>
<?php
foreach($topics as $topic){
    $topic = $topic['topic'];
    $url = ['topic/view', 'id'=>$topic['id']];
echo '<div class="cell item" ';if ($topic['alltop']==1) {echo 'style="background: url(/static/images/corner_star.png) no-repeat  right top;background-size: 20px 20px;"';}echo '><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td width="24" valign="top" align="center">',Html::a(Html::img('@web/'.str_replace('{size}', 'small', $topic['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</td><td width="10"></td><td width="auto" valign="middle"><span class="small fade"><strong>';echo Html::a(Html::encode($topic['author']['username']),['user/view', 'username'=>Html::encode($topic['author']['username'])]),'</strong></span><div class="sep5"></div> <span class="item_title">',Html::a(Html::encode($topic['title']), $url);if($topic['star']==1) {echo ' <i class="iconfont red">&#xe614;</i>';}echo'</span><div class="sep5"></div><span class="small fade">';if ($topic['comment_count']>0) {echo Yii::$app->formatter->asRelativeTime($topic['replied_at']),' &nbsp;•&nbsp; 最后回复来自 <strong>',Html::a(Html::encode($topic['lastReply']['username']),['user/view', 'username'=>Html::encode($topic['lastReply']['username'])]),'</strong>';}else{echo Yii::$app->formatter->asRelativeTime($topic['created_at']);}echo '</span></td>';if ($topic['comment_count']>0) {$gotopage = ceil($topic['comment_count']/intval($settings['comment_pagesize']));echo '<td width="70" align="right" valign="middle">',Html::a($topic['comment_count'], ['topic/view', 'id'=>$topic['id'],'p'=>$gotopage,'#'=>'reply'.$topic['comment_count']],['class'=>'count_livid']),'</td>';}echo '</tr></table></div>';}?>
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