<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\helpers\Url;
\app\themes\g2ex\layouts\AppAsset::register($this);
$settings = Yii::$app->params['settings'];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo Yii::$app->language; ?>">
<head>
<meta charset="<?php echo Yii::$app->charset; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link type="image/x-icon" href="/favicon.png" rel="shortcut icon">
<link rel="dns-prefetch" href="//7xrold.com1.z0.glb.clouddn.com">
<?php echo Html::csrfMetaTags(); ?>
<?php echo $settings['head_meta']; ?>
<title><?php echo Html::encode($this->title); ?></title>
<?php $this->head() ?>

<link href="/static/css/desktop.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>
<div id="Top">
<div class="content">
<div style="padding-top: 6px;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="110" align="left"><?php echo Html::a('<img src="/static/images/logo.png" border="0" align="default" alt="'.$settings['site_name'].' - '.$settings['slogan'].'" width="94" height="30" />', ['/'], ['name'=>'top','title'=>$settings['site_name'].' - '.$settings['slogan']]);?></td>
<td width="auto" align="left">
<div id="Search"><form class="navbar-form navbar-left" action="<?php echo Url::to(['topic/search']);?>" method="get"><div style="width: 276px; height: 28px; background-image: url('/static/images/search.png'); display: inline-block;"><button type="submit"></button><input type="text" maxlength="40" name="q" id="q" value="" /></div></form></div>
</td>
<td width="570" align="right" style="padding-top: 2px;"><?php echo Html::a('Главная', ['/'], ['class'=>'top']);?></td>
</tr>
</table>
</div>
<div class="btn-group-vertical" id="floatButton">
    <button type="button" class="btn btn-default" id="goTop" title="Вверх"><i class="iconfont">&#xe613;</i></button>
    <button type="button" class="btn btn-default" id="refresh" title="Обновить"><i class="iconfont">&#xe607;</i></button>
    <button type="button" class="btn btn-default" id="pageQrcode" title="QR"><i class="iconfont">&#xe60a;</i></span>
        <img class="qrcode" width="130" height="130" src="<?= Url::to(['/site/qrcode', 'url' => Yii::$app->request->absoluteUrl])?>">
    </button>
    <button type="button" class="btn btn-default" id="goBottom" title="Вниз"><i class="iconfont">&#xe612;</i></span></button>
</div>
</div>
</div>
<div id="Wrapper">
<div class="content">
<div id="Leftbar"></div>
<div id="Rightbar">
<?php echo $content; ?>
</div>
<div class="c"></div>
<div class="sep20"></div>
</div>
<div id="Bottom">
<div class="content">
<div class="inner">
<div class="sep10"></div>
<div class="fr">
<a href="https://portal.qiniu.com/signup?code=3lqtwq7wanb6a" target="_blank" title="本站图片空间由七牛云提供"><img src="http://7xrold.com1.z0.glb.clouddn.com/images/qiniu.png" width="100" border="0" alt="DigitalOcean" /></a>
</div>
<div class="sep20"></div>
<?php echo $settings['site_name']?>
<div class="sep10"></div>
<?php echo $settings['slogan']?>
<div class="sep20"></div>
<span class="small fade">Power by <a href="http://simpleforum.org" class="dark" target="_blank"><span class="small gray">SimpleForum <?php echo SIMPLE_FORUM_VERSION; ?></span></a>，Themes by <a href="http://www.g2ex.com" class="dark" target="_blank"><span class="small gray">龙城男人</span></a>，Design by <a href="http://www.v2ex.com" class="dark" target="_blank"><span class="small gray">OLIVIDA</span></a> &nbsp;  Time: <?php echo number_format( (microtime(true) - YII_BEGIN_TIME)*1000) . 'ms'; ?></span>
</div>
</div>
</div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
