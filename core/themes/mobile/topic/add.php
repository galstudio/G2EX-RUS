<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$session = Yii::$app->getSession();
$title = '创作新主题';
$this->title =Html::encode($settings['site_name']).' › '.$title;
$indexUrl = ['topic/index'];
$nodeUrl = ['topic/node', 'name'=>$model['node']['ename']];
?>
<div class="box" id="new">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a(Html::encode($model['node']['ename']),$nodeUrl); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?></div>
<?php if ( $session->hasFlash('postNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('postNG');?></div>
<?php }?>
<?=$this->render('_form', ['model' => $model,'content' => $content,'action' => 'add',]); ?>
</div>
<?=$this->render('@app/views/common/tips'); ?>