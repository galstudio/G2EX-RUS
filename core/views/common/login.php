<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
if(!Yii::$app->getUser()->getIsGuest()):
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
?>
<div class="sep20"></div>
<div class="box">
<div class="cell">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="48" valign="top"><?php echo SfHtml::uImg($me),SfHtml::uLink($me->username); ?></td>
            <td width="10" valign="top"></td>
            <td width="auto" align="left"><span class="fr fade"><?php if ($me->isWatingActivation()) {
                echo ' <small class="red">', Html::a('未激活', ['my/settings'],['style'=>'color:red']), '</small>';
            } else if ($me->isWatingVerification()) {
                echo ' <small class="red">未验证</small>';}else {?>
            <img src="/<?php echo SfHtml::uGroupRank($me->score);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px" title="<?php echo SfHtml::uGroup($me->score);?>"> <?php echo SfHtml::uGroup($me->score);?><?php } ?></span><span class="bigger"><?php echo Html::a(Html::encode($me->username), ['user/view', 'username'=>Html::encode($me->username)]);?></span>
            </td>
        </tr>
    </table>
    <div class="sep10"></div>
 <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="33%" align="center"><?php echo Html::a('<span class="bigger">'.$myInfo->favorite_node_count.'</span><div class="sep3"></div><span class="fade">Темы</span>', ['my/nodes'],['class'=>'dark','style'=>'display: block;']);?></td>
            <td width="34%" style="border-left: 1px solid rgba(100, 100, 100, 0.4); border-right: 1px solid rgba(100, 100, 100, 0.4);" align="center"><?php echo Html::a('<span class="bigger">'.$myInfo->favorite_topic_count.'</span><div class="sep3"></div><span class="fade">Топики</span>', ['my/topics'],['class'=>'dark','style'=>'display: block;']);?></td>
            <td width="33%" align="center"><?php echo Html::a('<span class="bigger">'.$myInfo->favorite_user_count.'</span><div class="sep3"></div><span class="fade">Читаю</span>', ['my/following'],['class'=>'dark','style'=>'display: block;']);?></td>
        </tr>
    </table>
</div>
<div class="cell" title="现有<?php echo $me->score;?>铜币 / 升级需要<?php echo SfHtml::uGroup($me->score);?>铜币">
<div style="width: 100%; background-color: #f0f0f0; height: 3px; display: inline-block; vertical-align: middle;"><div style="width: <?php echo ($me->score / SfHtml::uGroupNext($me->score) *100);?>%; background-color: #a9de62; height: 3px; display: inline-block;"></div></div>
</div>
<div class="cell" style="padding: 10px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="auto" valign="middle" align="left"><input type="button" class="super normal button" value="创建新主题" onclick="location.href = '/new'"></td>
             <td width="10"></td>
            <td width="auto" valign="middle" align="right"><input type="button" class="super normal button" value="发送新私信" onclick="location.href = '/send'"></td>
        </tr>
    </table>
</div>
<div class="cell"><div class="fr"><?php if ($me->getSmsCount()>0) { echo Html::a('<img src="/static/images/dot_orange.png" align="absmiddle"> <strong class="red">'.$me->getSmsCount().' сообщение</strong>', ['my/sms']);}else{echo Html::a($me->getSmsCount().' сообщение', ['my/sms']);}; ?></div><?php if ($me->getSystemNoticeCount()>0) { echo Html::a('<img src="/static/images/dot_orange.png" align="absmiddle"> <strong class="red">'.$me->getSystemNoticeCount().' напомининие</strong>', ['my/notifications']);}else{echo Html::a($me->getSystemNoticeCount().' напомининие', ['my/notifications']);}; ?></div>
<div class="inner"><div class="fr" id="money"><?php echo Html::a(SfHtml::uScore($me->score), ['my/balance'], ['class'=>'balance_area']); ?></div><?php if ( intval(Yii::$app->params['settings']['close_register']) === 2 ) {;?><a href="/my/invite-codes" class="dark" title="我的邀请码"><i class="iconfont f20">&#xe619;</i> 邀请码</a><?php };?>&nbsp;</div>
<?php if ( $me->reg==0 ) {?>
<div class="dock_area">
<div class="inner"><span class="chevron">&nbsp;›&nbsp;</span> <a href="/balance">在你开始发帖之前，请先领取初始资本</a></div>
</div>
<?php }?>
</div>
<?php if( !$me->checkTodaySigned() ) :?>
<div class="sep20"></div>
<div class="box"><div class="inner"><i class="iconfont" style="color: #f90;">&#xe601;</i> &nbsp;<a href="/mission/daily">领取今日的登录奖励</a></div></div>
<?php endif; ?>
<?php else: ?>
<div class="sep20"></div>
<div class="box">
    <div class="cell">
        <strong><?php echo $settings['site_name']?> = go to explore</strong>
        <div class="sep5"></div>
        <span class="fade"><?php echo $settings['slogan']?></span>
    </div>
    <div class="inner">
        <div class="sep5"></div>
        <div align="center"><?php echo Html::a('现在注册', ['site/signup'], ['class'=>'super normal button']); ?>
        <div class="sep5"></div>
        <div class="sep10"></div>
        已注册用户请 &nbsp;<?php echo Html::a('登录', ['site/signin']); ?></div>
    </div>
</div>
<?php endif; ?>
