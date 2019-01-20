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
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::encode($message); ?></div>
<div class="cell">
<span class="gray bigger"><?=Html::encode($name); ?></span>
</div>
<div class="cell"><?=nl2br(Html::encode($message)); ?></div>
<div class="inner">← <a href="/">на главную</a></div>
    </div>
</div>
