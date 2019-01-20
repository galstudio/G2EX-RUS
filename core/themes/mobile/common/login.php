<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<?php if(!$isGuest){?>
<?php if( $me->checkTodaySigned() === false ) :?>
<div class="inner"><i class="iconfont icon-gift" style="color: #f90;"></i> &nbsp;<a href="/mission/daily">领取今日的登录奖励</a></div></div>
<div class="sep5"></div>
<div class="box">
<?php endif; ?>
<div class="cell"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tbody><tr><td width="auto">
<?php if ($me->getSystemNoticeCount()>0) {?>
<input type="button" class="super special button" value="<?=$me->getSystemNoticeCount()?> 条未读提醒" onclick="location.href = '/notifications';" style="display:inline-block;width: 49%; line-height: 20px;">
<?php }else{echo Html::a($me->getSystemNoticeCount().' 条未读提醒', ['my/notifications'],['class'=>'gray','style'=>'display:inline-block;width: 47%; line-height: 20px;']);}; ?>
<?php if ($me->getSmsCount()>0) {?>
<input type="button" class="super special button" value="<?=$me->getSmsCount()?> 条未读私信" onclick="location.href = '/sms';" style="display:inline-block;width: 49%; line-height: 20px;">
<?php }else{echo Html::a($me->getSmsCount().' 条未读私信', ['my/sms'],['class'=>'gray','style'=>'display:inline-block; width: 47%; line-height: 20px;']);}; ?>
</td><td width="auto" align="right"><?=Html::a(SfHtml::uScore($me->score), ['my/balance'], ['class'=>'balance_area']); ?></td></tr></tbody></table></div>
<?php }?>