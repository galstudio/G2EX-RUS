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
$this->title = Html::encode($settings['site_name']) .' › 充值 › 微信';
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
    History::ACTION_GOOD_TOPIC => '感谢主题',
    History::ACTION_GOOD_COMMENT => '感谢回复',
    History::ACTION_TOPIC_THANKED => '主题收到谢意',
    History::ACTION_COMMENT_THANKED => '回复收到谢意',
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
        $str = '感谢了'.SfHtml::uLink($ext['thank_to']).'的主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_GOOD_COMMENT ) {
        $str = '感谢了'.SfHtml::uLink($ext['thank_to']).'在主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . ' 中的回复';
    } else if( $action == History::ACTION_TOPIC_THANKED ) {
        $str = SfHtml::uLink($ext['thank_by']).' 感谢了您的主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_COMMENT_THANKED ) {
        $str = SfHtml::uLink($ext['thank_by']).' 感谢了您在主题 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . ' 中的回复';
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
<?=Html::a('排行榜', ['top/rich'],['class'=>'op']); ?> <?=Html::a('余额', ['my/balance'],['class'=>'op']); ?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a('账户余额', ['my/balance']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 微信充值</div>
<div class="cell">
        <div class="topic_content"><div class="fr"><img src="/static/images/wx.jpg" width="100" height="100" style="margin-left: 10px;"></div>
        你可以通过微信转账方式向 <?=Html::encode($settings['site_name'])?> 充值。目前的实现方式是手工的，我们在收到你的充值之后，就会尽快向你的账户发放铜币。<strong>请在微信的付款说明中填入你的 <?=Html::encode($settings['site_name'])?> 用户名。</strong>充值金额越大，获得的铜币、银币甚至金币就会越多。推荐使用微信的移动客户端支付，目前可以免除手续费。
        <div class="sep10"></div>
        如果你在扫码支付的过程中，忘记了或者没有机会填入你的 <?=Html::encode($settings['site_name'])?> 用户名的话，你可以在支付结束后发 <a href="/send?to=龙城男人"><strong class="green">私信</strong></a> 告诉我，并且附上转账的微信号。
        <div class="sep10"></div>
        <i class="iconfont">&#xe61a;</i> <a href="https://itunes.apple.com/cn/app/wei/id414478124" target="_blank">微信 for iOS</a>
        <div class="sep10"></div>
        <i class="iconfont green">&#xe61b;</i></li> <a href="https://weixin.qq.com/" target="_blank">微信 for Android</a>
        </div>
    </div>
<div class="cell">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td width="auto" align="left" valign="middle" style="font-size: 14px;">
                &nbsp;充值 10 元获得 1,000 铜币
            </td>
            <td width="100" align="right">
            <a href="https://weixin.qq.com/" target="_blank" class="super normal button">打开微信网站</a>
            </td>
        </tr></tbody></table>
    </div>
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
            '<td class="d"><small class="gray">', $formatter->asDateTime($record['action_time'], 'y-MM-dd HH:mm:ss xxx'), '</td>',
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