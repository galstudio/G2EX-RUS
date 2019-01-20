<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$formatter = Yii::$app->getFormatter();
$this->title = Html::encode($settings['site_name']) . ' › 日常任务';
$me = Yii::$app->getUser()->getIdentity();
$session = Yii::$app->getSession();
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 日常任务</div>
<?php
   $continue = $me->checkTodaySigned();
   if ($continue === false) {
?>
<div class="cell">
<h1>每日登录奖励 <?=$formatter->asDateTime(time(), 'yMMdd')?></h1>
<input type="button" class="super normal button" value="领取 X 铜币" onclick="location.href = '/mission/daily';" data-method="post">
</div>
<?php }else{?>
<?php if ( $session->hasFlash('SigninOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('SigninOK');?></div>
<?php }?>
<div class="cell">
<span class="gray">&nbsp;每日登录奖励已领取</span>
<div class="sep10"></div>
<input type="button" class="super normal button" value="查看我的账户余额" onclick="location.href = '/balance';">
</div>
<div class="cell">已连续登录 <?=$continue;?> 天</div>
<?php }; ?>
</div>