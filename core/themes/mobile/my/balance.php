<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\History;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › 账户余额';
$session = Yii::$app->getSession();
$formatter = Yii::$app->getFormatter();
$me = Yii::$app->getUser()->getIdentity();
$currentPage = $pages->page+1;
$types = [
    History::ACTION_REG => '注册帐号',
    History::ACTION_ADD_TOPIC => '创建主题',
    History::ACTION_ADD_COMMENT => '创建回复',
    History::ACTION_COMMENTED => '主题回复收益',
    History::ACTION_ORIGINAL_SCORE => '初始资本',
    History::ACTION_SIGNIN => '每日登录奖励',
    History::ACTION_SIGNIN_10DAYS => '连续登录奖励',
    History::ACTION_INVITE_CODE => '购买邀请码',
    History::ACTION_MSG => '发送私信',
    History::ACTION_GOOD_TOPIC => '发送谢意',
    History::ACTION_GOOD_COMMENT => '发送谢意',
    History::ACTION_TOPIC_THANKED => '收到谢意',
    History::ACTION_COMMENT_THANKED => '收到谢意',
    History::ACTION_CHARGE_POINT => '充值',
];

function getComment($action, $ext) {
    $str = '';
    if( $action == History::ACTION_ADD_TOPIC ) {
        $str = '创建了主题 › ' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_ADD_COMMENT ) {
        $str = '创建了回复 › ' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_ORIGINAL_SCORE ) {
        $str = '获得初始资本 ' . $ext['cost'];
    } else if( $action == History::ACTION_COMMENTED ) {
        $str = '收到 ' . Html::a(Html::encode($ext['commented_by']), ['user/view', 'username'=>$ext['commented_by']]) . ' 的回复 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_SIGNIN ) {
        $str = '每日登录奖励 ' . $ext['cost'] . ' 铜币';
    } else if( $action == History::ACTION_SIGNIN_10DAYS ) {
        $str = '连续登录每 10 天奖励 ' . $ext['cost'] . ' 铜币';
    } else if( $action == History::ACTION_INVITE_CODE ) {
        $str = '购买了 ' . $ext['amount'] . ' 枚邀请码';
    } else if( $action == History::ACTION_REG ) {
        $str = '注册帐号奖励 ' . $ext['cost'] . ' 铜币';
    }  else if( $action == History::ACTION_MSG ) {
        $str = '给 ' . Html::a(Html::encode($ext['target']), ['user/view', 'username'=>$ext['target']]) . ' 发送私信';
    }else if( $action == History::ACTION_GOOD_TOPIC ) {
        $str = '感谢 '.SfHtml::uLink($ext['thank_to']).' 的主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_GOOD_COMMENT ) {
        $str = '感谢 '.SfHtml::uLink($ext['thank_to']).' 的回复 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_TOPIC_THANKED ) {
        $str = SfHtml::uLink($ext['thank_by']).' 感谢你的主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_COMMENT_THANKED ) {
        $str = SfHtml::uLink($ext['thank_by']).' 感谢你在 '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . ' 的回复';
    } else if( $action == History::ACTION_CHARGE_POINT ) {
        $str = '充值 ' . $ext['cost'] . ' 铜币。附言：'. Html::encode($ext['msg']);
    }
    return $str;
}
function getCostName($cost) {
    $cost = intval($cost);
    $color = $cost>0?'positive':'negative';
    return '<span class="' . $color . '"><strong>' . $cost . '</strong></span>';
}
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="cell"><div class="fr" style="margin-top: -3px">
<?=Html::a('排行榜', ['top/rich'],['class'=>'op']); ?> <?=Html::a('充值', ['my/add'],['class'=>'op']); ?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 账户余额</div>
<div class="cell">
    <table cellpadding="10" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td width="200">
            <span class="gray">当前账户余额</span>
            <div class="sep10"></div>
            <div class="sep5"></div>
            <div class="balance_area" style="font-size: 20px; line-height: 24px;"><?=SfHtml::uScore($me->score); ?></div></td><?php if ( intval(Yii::$app->params['settings']['close_register']) === 2 ) {;?>
             <td width="100"><span class="fr"><?=Html::a('购买邀请码', ['service/buy-invite-code'],['class' => 'super normal button']); ?></span></td><?php };?>
        </tr>
    </tbody></table>
</div>
<?php if ( $session->hasFlash('RegNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('RegNG');?></div>
<?php } else if ( $session->hasFlash('RegOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('RegOK');?></div>
<?php }?>
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
            <td width="40" class="h">时间</td>
            <td width="50" class="h">类型</td>
            <td width="30" class="h">数额</td>
            <td width="30" class="h">余额</td>
            <td width="auto" class="h" style="border-right: none;">描述</td>
        </tr>
<?php
foreach($records as $record) {
    $ext = json_decode($record['ext'], true);
    echo '<tr>',
            '<td class="d"><small class="gray">', $formatter->asDateTime($record['action_time'], 'y-MM-dd HH:mm:ss'), '</td>',
            '<td class="d">', $types[$record['action']], '</td>',
            '<td class="d" style="text-align: right;">', getCostName($ext['cost']), '</td>',
            '<td class="d" style="text-align: right;">', $ext['score'], '</td>',
            '<td class="d" style="border-right: none;"><span class="gray">', getComment($record['action'], $ext), '</span></td>',
         '</tr>';
}
?>
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
<?php if ( $me->reg==0 ) {?>
<div class="sep20"></div>
<div class="box">
    <div class="header">可完成的任务</div>
    <div class="inner">
        <h2>获得初始资本</h2>
        欢迎来到 <?=Html::encode($settings['site_name'])?>，这是一个关于分享和探索的社区。你在进入这里时，你会获得 1000 铜币。接下来你在社区内的一切行为，包括创建主题和回复等，都将会消耗铜币。而当你完成了一些有意义的事情时，你就会收获铜币，以及，好心情。
        <div class="sep20"></div>
         <strong>任务要求</strong>
        <div class="sep10"></div>
        创建一个新主题。
        <div class="sep10"></div>
        <strong>任务奖励</strong>
        <div class="sep10"></div>
        <div class="balance_area" style="">10 <img src="/static/images/silver.png" alt="S" align="absmiddle" border="0" style="padding-bottom: 2px;"> </div>
        <div class="sep20"></div>
        <input type="button" onclick="location.href = '/mission/complete';" value="完成任务" class="super normal button" data-method="post">
    </div>
</div>
<?php }?>