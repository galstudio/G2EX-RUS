<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$session = Yii::$app->getSession();
$this->title = Html::encode($settings['site_name']);
$title = '论坛暂时关闭';
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?></div>
<div class="cell">
<?=Alert::widget([
   'options' => ['class' => 'alert-danger'],
   'closeButton'=>false,
   'body' => Yii::$app->params['settings']['offline_msg'],
]);
?>
</div>
    </div>
</div>
