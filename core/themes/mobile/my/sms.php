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
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › 私信';
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
<div class="header"><div class="fr f12"><span class="snow">总共收到私信&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 私信</div>
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
<div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
        <tbody><tr>
            <td width="100" colspan="2" class="h">发件人</td>
            <td width="auto" class="h">内容</td>
            <td width="60" class="h">时间</td>
            <td width="30" class="h" style="border-right: none;">操作</td>
        </tr>
<?php
foreach($sms as $notice) {
    echo '<tr><td align="right" width="30" valign="middle" class="d" style="border-right: none;">',
    Html::a(Html::img('@web/'.str_replace('{size}', 'small', $notice['source']['avatar']), ['class'=>'avatar fr','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($notice['source']['username'])]),
            '</td><td align="left" width="70" valign="middle" class="d" style="min-width:60px;"><span class="fade">',
            Html::a('<strong>'.Html::encode($notice['source']['username']).'</strong>', ['user/view', 'username'=>Html::encode($notice['source']['username'])]).'</td>';
                    echo '<td align="left" valign="top" class="d" style="word-break:break-all"><span class="gray">',$notice['msg'].'</span>
        </td><td width="60" align="left" valign="top" class="d"><span class="fade fr">',Yii::$app->formatter->asRelativeTime($notice['created_at']),
                '</span><td width="30" align="left" valign="top" class="d" style="border-right: none;">', Html::a('<img src="/static/images/reply.png" align="absmiddle" border="0" alt="回复" />', ['service/sms', 'id'=>$notice['id']],['title'=>'回复']);echo '</td></tr>';
}?>
</tbody></table>
</div>
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