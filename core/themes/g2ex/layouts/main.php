<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Page;
use app\components\SfHtml;
\app\themes\g2ex\layouts\AppAsset::register($this);
$settings = Yii::$app->params['settings'];
$baseUrl = \Yii::$app->getRequest()->getBaseUrl();
$this->registerJs('var baseUrl = \''.$baseUrl.'\';', \yii\web\View::POS_HEAD);
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?=Yii::$app->language; ?>">
<head>
<meta charset="<?=Yii::$app->charset; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link type="image/x-icon" href="/favicon.png" rel="shortcut icon">
<?=Html::csrfMetaTags(); ?>
<?=$settings['head_meta']; ?>

<title><?=Html::encode($this->title); ?><?php if (!$isGuest && $me->getNoticeCount()>0) {echo ' ('.Html::encode($me->getNoticeCount()).')';}?></title>
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="Top">
<div class="content">
<div style="padding-top: 6px;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="110" align="left"><?=Html::a('<img src="/static/images/logo.png" border="0" align="default" alt="'.$settings['site_name'].' - '.$settings['slogan'].'" width="94" height="30" />', ['/'], ['name'=>'top','class'=>'pjax','title'=>$settings['site_name'].' - '.$settings['slogan']]);?></td>
<td width="auto" align="left">
<div id="Search"><form class="navbar-form navbar-left" action="<?=Url::to(['topic/search']);?>" method="get"><div style="width: 276px; height: 28px; background-image: url('/static/images/search.png'); display: inline-block;"><button type="submit"></button><input type="text" maxlength="40" name="q" id="q" value="" /></div></form></div>
</td>
<td width="570" align="right" style="padding-top: 2px;"><?=Html::a('Главная', ['/'], ['class'=>'top']);?>&nbsp;&nbsp;&nbsp;<?php if(!$isGuest){?>
<?=Html::a($me->username, ['user/view', 'username'=>Html::encode($me->username)], ['class'=>'top']);if ($me->isWatingActivation()) { echo ' <small class="red">', Html::a('Не активирован', ['my/settings'],['style'=>'color:red']), '</small>';} else if ($me->isWatingVerification()) {echo ' <small class="red">не проверен</small>';}  ?>&nbsp;&nbsp;&nbsp;
<?=Html::a('Настройки', ['my/settings'], ['class'=>'top']); ?>&nbsp;&nbsp;&nbsp;
<?php if(!$isGuest && $me->isAdmin()){ ?>
<?=Html::a('Админпанель', ['admin/setting/all'], ['class'=>'top']); ?>&nbsp;&nbsp;&nbsp;
<?php }?>
<?=Html::a('Выход', ['site/signout'], ['data'=>['confirm' => 'Вы действительно хотите выйти из системы?','method' => 'post'],'class'=>'top']); ?>
<?php }else{?><?=Html::a('Регистрация', ['site/signup'], ['class'=>'top']); ?>&nbsp;&nbsp;&nbsp;<?=Html::a('Вход', ['site/signin'], ['class'=>'top']); ?><?php }?></td>
</tr>
</table>
</div>
<div class="btn-group-vertical" id="floatButton">
    <button type="button" class="btn btn-default" id="goTop" title="去顶部"><i class="iconfont">&#xe613;</i></button>
    <button type="button" class="btn btn-default" id="refresh" title="刷新"><i class="iconfont">&#xe607;</i></button>
    <button type="button" class="btn btn-default" id="pageQrcode" title="扫二维码访问本页"><i class="iconfont">&#xe60a;</i></span>
        <img class="qrcode" width="130" height="130" src="<?= Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])?>">
    </button>
    <button type="button" class="btn btn-default" id="goBottom" title="去底部"><i class="iconfont">&#xe612;</i></span></button>
</div>
</div>
</div>
<div id="Wrapper">
<div class="content">
<div id="Leftbar"></div>
<div id="Rightbar">
<?=$content; ?>
</div>
<div class="c"></div>
<div class="sep20"></div>
</div>
<div id="Bottom">
<div class="content">
<div class="inner">
<div class="sep10"></div>
<div class="fr">
<a href="https://portal.qiniu.com/signup?code=3lqtwq7wanb6a" target="_blank" title="本站图片空间由七牛云提供"><img src="http://7xrold.com1.z0.glb.clouddn.com/images/qiniu.png" width="100" border="0" alt="本站图片空间由七牛云提供" /></a>
</div>
<strong>
<?php
$single = Page::getSingle();
foreach($single as $page) {
    if(!empty($page['url'])) {
    echo '<a href="'.$page['url'].'" class="dark" target="_blank" rel="external">'.Html::encode($page['name']).'</a> &nbsp;&nbsp;';
    }else{
    echo Html::a(Html::encode($page['name']), ['page/'.$page['ename']], ['class'=>'dark']),' &nbsp;&nbsp;';
    }
}
?>
</strong>
<div class="sep20"></div>
<?=$settings['site_name']?>
<div class="sep10"></div>
<?=$settings['slogan']?>
<div class="sep20"></div>
<span class="small fade">Power by <a href="http://simpleforum.org" class="dark" target="_blank"><span class="small gray">SimpleForum <?=SIMPLE_FORUM_VERSION; ?></span></a>，Themes by <a href="http://www.g2ex.com" class="dark" target="_blank"><span class="small gray">龙城男人</span></a>，Design by <a href="http://www.v2ex.com" class="dark" target="_blank"><span class="small gray">OLIVIDA</span></a> &nbsp;  Time: <?=number_format( (microtime(true) - YII_BEGIN_TIME)*1000) . 'ms'; ?></span>
</div>
</div>
</div>
<?php $this->endBody() ?>

<?php if(!$isGuest && $myInfo->css_close ==0){?>
<style type="text/css">
<?=Html::encode($myInfo->mycss)?>
</style>
<?php }?>
</body>
</html>
<?php $this->endPage() ?>
