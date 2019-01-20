<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\History;
use app\models\Token;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › 我的邀请码';
$formatter = Yii::$app->getFormatter();
$me = Yii::$app->getUser()->getIdentity();
$currentPage = $pages->page+1;
function getRecord($status, $ext) {
    $str = '';
    if( $status == 1 ) {
        $str = Html::encode($ext['username']);
    }
    return $str;
}
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('邀请码', ['my/invite-codes']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 我的邀请码</div>
<div class="cell">
    <table cellpadding="10" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td width="200">
            <span class="gray">当前账户余额</span>
            <div class="sep10"></div>
            <div class="sep5"></div>
            <div class="balance_area" style="font-size: 20px; line-height: 24px;"><?=SfHtml::uScore($me->score); ?></div></td>
            <td width="100"><span class="fr"><?=Html::a('购买邀请码', ['service/buy-invite-code'],['class' => 'super normal button']); ?></span></td>
        </tr>
    </tbody></table>
</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="75%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="25%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
        <tbody><tr>
            <td width="40" class="h">邀请码</td>
            <td width="30" class="h">期限</td>
            <td width="50" class="h">购买日期</td>
            <td width="50" class="h">使用日期</td>
            <td width="40" class="h">状态</td>
            <td width="auto" class="h">使用人</td>
        </tr>
<?php
foreach($records as $record) {
    $ext = json_decode($record['ext'], true);
    echo '<tr', ($record['status']==0)?'':' class="active"', '>',
            '<td class="d">', ($record['status']==0)?$record['token']:'<span class="fade"">'.$record['token'].'</span>', '</td>',
            '<td class="d">', ($record['expires'] == 0)?'永久':$formatter->asDateTime($record['expires'], 'y-MM-dd HH:mm:ss'), '</td>',
            '<td class="d">', $formatter->asDateTime($record['created_at'], 'y-MM-dd HH:mm'), '</td>',
            '<td class="d">', ($record['created_at'] == $record['updated_at'])?'':$formatter->asDateTime($record['updated_at'], 'y-MM-dd HH:mm'), '</td>',
            '<td class="d">', ($record['status']==0)?'<span class="positive"><strong>未使用</strong></span>':'<span class="negative"><strong>已使用</strong></span>', '</td>',
            '<td class="d">',SfHtml::uLink(getRecord($record['status'], $ext)), '</td>',
         '</tr>';
}
?>
    </tbody></table>
</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="75%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>3,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="25%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>