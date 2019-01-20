<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Page;
\app\themes\g2ex\layouts\MobileAsset::register($this);
$settings = Yii::$app->params['settings'];
$baseUrl = \Yii::$app->getRequest()->getBaseUrl();
$this->registerJs('var baseUrl = \''.$baseUrl.'\';', \yii\web\View::POS_HEAD);
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
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
<meta content="True" name="HandheldFriendly" />
<meta name="Referrer" content="unsafe-url">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="theme-color" content="#333344" />
<link rel="icon" sizes="192x192" href="/static/images/g2ex_192.png" />
<link type="image/x-icon" href="/static/images/favicon.png" rel="shortcut icon">
<?=Html::csrfMetaTags(); ?>
<?=$settings['head_meta']; ?>
<title><?=Html::encode($this->title); ?></title>
<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="Top">
<div class="content">
<div style="padding-top: 6px;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td width="5" align="left"></td>
<td width="80" align="left" style="padding-top: 4px;"><?=Html::a('<img src="/static/images/logo.png?v=2016" border="0" align="default" alt="'.$settings['site_name'].'" width="80" height="25" />', ['/'], ['name'=>'top','title'=>'G2EX']);?></td>
<td width="auto" align="right" style="padding-top: 2px;">
<?php if(!$isGuest){?>
<?=Html::a(Html::img('@web/'.str_replace('{size}', 'small',$me->avatar), ['align' => 'absmiddle','style'=>'border-radius: 24px;max-width: 24px; max-height: 24px;']), ['user/view', 'username'=>Html::encode($me->username)]); ?>
&nbsp;
<?=Html::a('&nbsp;<i class="iconfont icon-plus"></i>&nbsp;', ['topic/new'], ['class'=>'top']); ?>&nbsp;
<?=Html::a('&nbsp;<i class="iconfont icon-cog"></i>&nbsp;', ['my/settings'], ['class'=>'top']); ?>&nbsp;
<?php if(!$isGuest && $me->isAdmin()){ ?>
<?=Html::a('&nbsp;<i class="iconfont icon-cogs"></i>&nbsp;', ['admin/setting/all'], ['class'=>'top']); ?>&nbsp;
<?php }?>
<?=Html::a('&nbsp;<i class="iconfont icon-more"></i>&nbsp;', ['site/more'], ['class'=>'top']); ?>
<?php }else{?>
<?=Html::a('首页', ['/'], ['class'=>'top']);?>&nbsp;&nbsp;<?=Html::a('注册', ['site/signup'], ['class'=>'top']); ?>&nbsp;&nbsp;<?=Html::a('登录', ['site/signin'], ['class'=>'top']); ?><?php }?></td>
<td width="5" align="left"></td>
</tr>
</table>
</div>
</div>
</div>
<div id="Wrapper">
<div class="content">
<?=$content; ?>
</div>
<div id="Bottom">
<div class="content">
<div class="inner">
<div class="fr">
<strong>
<?php
$single = Page::getSingle();
foreach($single as $page) {
    if(!empty($page['url'])) {
    echo '<a href="'.$page['url'].'" class="dark" target="_blank" rel="external">'.Html::encode($page['name']).'</a> &nbsp;';
    }else{
    echo Html::a(Html::encode($page['name']), ['page/'.$page['ename']], ['class'=>'dark']),' &nbsp;';
    }
}
?><a href="https://portal.qiniu.com/signup?code=3lqtwq7wanb6a" target="_blank" title="本站图片空间由七牛云提供">七牛云存储</a>
</strong>
</div>
&copy;  <a href="http://www.g2ex.com"><?=$settings['site_name']?></a>&nbsp; · &nbsp;<?=number_format( (microtime(true) - YII_BEGIN_TIME)*1000) . 'ms'; ?>
</div>
</div>
</div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>