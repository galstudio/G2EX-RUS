<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Notice;
use app\models\Topic;
use app\models\Comment;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › Система уведомлений';
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
$currentPage = $pages->page+1;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><div class="fr f12"><span class="snow">Получено в общей сложности уведомлений&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Система уведомлений</div>
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
foreach($notices as $notice) {
    echo '<div class="cell"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td width="32" align="left" valign="top">',
    Html::a(Html::img('@web/'.str_replace('{size}', 'small', $notice['source']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($notice['source']['username'])]),
            '</td><td valign="middle"><span class="fade">',
            Html::a('<strong>'.Html::encode($notice['source']['username']).'</strong>', ['user/view', 'username'=>Html::encode($notice['source']['username'])]).'&nbsp;';
                if($notice['type'] == Notice::TYPE_COMMENT) {
                    echo 'в «'. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . '» оставил комментарий',
                        $notice['notice_count']>0?'<span class="small gray">(пропущено похожих уведомлений '.$notice['notice_count'].')</span>':'';
                } else if($notice['type'] == Notice::TYPE_MENTION) {
                    if ($notice['position'] > 0) {
                        echo 'в › «'. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . '» упомянул вас';
                    } else {
                        echo 'в топике › «'. Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]) . '» вас упомянули';
                    }
                } else if($notice['type'] == Notice::TYPE_FOLLOW_TOPIC) {
                        echo 'добавил топик › «', Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]) . '» в избранное';
                } else if($notice['type'] == Notice::TYPE_GOOD_TOPIC) {
                        echo 'понравился ваш топик › «', Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]) . '»';
                } else  if($notice['type'] == Notice::TYPE_GOOD_COMMENT) {
                    echo 'в топике › «'. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . '» понравился комментарий';
            }  else  if($notice['type'] == Notice::TYPE_THANK_TOPIC) {
                    echo 'поблагодарил за топик › «'. Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]) . '»';
            }  else  if($notice['type'] == Notice::TYPE_THANK_COMMENT) {
                    echo 'в › «'. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . '» поблагодарил за комментарий';
            } else if($notice['type'] == Notice::TYPE_FOLLOW_USER) {
                        echo 'стал читать вас';
                }
        echo '</span> &nbsp; <span class="snow">',Yii::$app->formatter->asRelativeTime($notice['created_at']),
                '</span>';
 if($notice['type'] == Notice::TYPE_COMMENT) {
    $comment=Comment::find()->where(['user_id'=>$notice['source']['id'],'topic_id'=>$notice['topic']['id'],'position'=>$notice['position']])->one();
    $editorClass = '\app\plugins\\'. $comment['topic']['node']['editor']. '\\'. $comment['topic']['node']['editor'];
    $editor = new $editorClass();
    \app\themes\g2ex\layouts\emojiAsset::register($this);
    echo '<div class="sep5"></div><div class="payload">'.$editor->parse($comment['content']).'</div>';
}
 echo ' </td></tr></tbody></table></div>';
}?>
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
</div>
