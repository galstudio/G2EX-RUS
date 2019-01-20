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
$this->title = Html::encode($settings['site_name']).' › '.Html::encode($message);
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::encode($message); ?></div>
<div class="cell">
<span class="gray bigger"><?=Html::encode($name); ?></span>
</div>
<div class="cell"><?=nl2br(Html::encode($message)); ?></div>
<div class="inner">← <a href="/">返回首页</a></div>
    </div>
</div>