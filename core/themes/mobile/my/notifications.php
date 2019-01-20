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
$this->title = Html::encode($settings['site_name']).' › 提醒系统';
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
$currentPage = $pages->page+1;
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><div class="fr f12"><span class="snow">总共收到提醒&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 提醒系统</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="75%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="25%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<?php
foreach($notices as $notice) {
    echo '<div class="cell"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td width="32" align="left" valign="top">',
    Html::a(Html::img('@web/'.str_replace('{size}', 'small', $notice['source']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($notice['source']['username'])]),
            '</td><td valign="middle"><span class="fade">',
            Html::a('<strong>'.Html::encode($notice['source']['username']).'</strong>', ['user/view', 'username'=>Html::encode($notice['source']['username'])]).'&nbsp;';
                if($notice['type'] == Notice::TYPE_COMMENT) {
                    echo '在 '. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . ' 里回复了你',
                        $notice['notice_count']>0?'<span class="small gray">(省略类似通知'.$notice['notice_count'].'次)</span>':'';
                } else if($notice['type'] == Notice::TYPE_MENTION) {
                    if ($notice['position'] > 0) {
                        echo '在回复 › '. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . ' 时提到了你';
                    } else {
                        echo '在主题 › '. Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]) . ' 中提到了你';
                    }
                } else if($notice['type'] == Notice::TYPE_FOLLOW_TOPIC) {
                        echo '收藏了你发布的主题 › ', Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]);
                } else if($notice['type'] == Notice::TYPE_GOOD_TOPIC) {
                        echo '赞了你发布的主题 › ', Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]);
                } else  if($notice['type'] == Notice::TYPE_GOOD_COMMENT) {
                    echo '赞了你在主题 › '. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . ' 里的回复';
            }  else  if($notice['type'] == Notice::TYPE_THANK_TOPIC) {
                    echo '感谢了你发布的主题 › '. Html::a(Html::encode($notice['topic']['title']), ['topic/view', 'id'=>$notice['topic_id']]);
            }  else  if($notice['type'] == Notice::TYPE_THANK_COMMENT) {
                    echo '感谢了你在主题 › '. Html::a(Html::encode($notice['topic']['title']), Topic::getRedirectUrl($notice['topic_id'], $notice['position'])) . ' 里的回复';
            }else if($notice['type'] == Notice::TYPE_CHARGE_POINT) {
                            echo '给你充值积分 '.Html::a(Html::encode($notice['msg']), ['my/balance']);
            } else if($notice['type'] == Notice::TYPE_FOLLOW_USER) {
                        echo '关注了你';
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
<tr><td width="75%" align="left">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?php echo $pages->pagecount;?>" class="page_normal"><?php echo $pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?php echo $currentPage;?>" min="1" max="<?php echo $pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="25%" align="right">
<div class="fr">
<?php echo LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>