<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$this->title = empty($title)?'操作结果':Html::encode($settings['site_name']).' › '.$title;
$title = empty($title)?'操作结果':$title;
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?></div>
<div class="<?=$status;?>"><?=$msg;?></div>
</div>
</div>
