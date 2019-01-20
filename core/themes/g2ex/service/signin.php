<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$formatter = Yii::$app->getFormatter();
$this->title = Html::encode($settings['site_name']) . ' › Ежедневные задачи';
$me = Yii::$app->getUser()->getIdentity();
$session = Yii::$app->getSession();
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Ежедневные задачи</div>
<?php
   $continue = $me->checkTodaySigned();
   if ($continue === false) {
?>
<div class="cell">
<h1>Ежедневный бонус за вход <?=$formatter->asDateTime(time(), 'dd.MM.y')?></h1>
<input type="button" class="super normal button" value="Собрать монеты" onclick="location.href = '/mission/daily';" data-method="post">
</div>
<?php }else{?>
<?php if ( $session->hasFlash('SigninOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('SigninOK');?></div>
<?php }?>
<div class="cell">
<span class="gray">&nbsp;Ежедневная награда уже получена</span>
<div class="sep10"></div>
<input type="button" class="super normal button" value="Посмотреть мой баланс" onclick="location.href = '/balance';">
</div>
<div class="cell">Последовательный вход: <?=$continue;?> день</div>
<?php }; ?>
</div>
</div>
