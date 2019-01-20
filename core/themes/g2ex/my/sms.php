<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › Персональные сообщения';
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
<div class="header"><div class="fr f12"><span class="snow">Всего сообщений&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Персональные сообщения</div>
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
<div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
        <tbody><tr>
            <td width="120" colspan="2" class="h">Отправитель</td>
            <td width="auto" class="h">Текст сообщения</td>
            <td width="60" class="h">Время</td>
            <td width="30" class="h" style="border-right: none;">Действия</td>
        </tr>
<?php
foreach($sms as $notice) {
    echo '<tr><td align="right" width="30" valign="middle" class="d" style="border-right: none;">',
    Html::a(Html::img('@web/'.str_replace('{size}', 'small', $notice['source']['avatar']), ['class'=>'avatar fr','border'=>'0','align' => 'default']), ['user/view', 'username'=>Html::encode($notice['source']['username'])]),
            '</td><td align="left" width="90" valign="middle" class="d" style="min-width:60px;"><span class="fade">',
            Html::a('<strong>'.Html::encode($notice['source']['username']).'</strong>', ['user/view', 'username'=>Html::encode($notice['source']['username'])]).'</td>';
                    echo '<td align="left" valign="top" class="d" style="word-break:break-all"><span class="gray">',$notice['msg'].'</span>
        </td><td width="60" align="left" valign="top" class="d"><span class="fade fr">',Yii::$app->formatter->asRelativeTime($notice['created_at']),
                '</span><td width="30" align="left" valign="top" class="d" style="border-right: none;">', Html::a('<img src="/static/images/reply.png" align="absmiddle" border="0" title="Ответить" alt="Ответить" />', ['service/sms', 'id'=>$notice['id']],['title'=>'Ответить']);echo '</td></tr>';
}?>
</tbody></table>
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
</div>
</div>
