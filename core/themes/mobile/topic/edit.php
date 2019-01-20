<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$title = '编辑主题';
$this->title =Html::encode($settings['site_name']).' › '.$title;
$request = Yii::$app->getRequest();
$me = Yii::$app->getUser()->getIdentity();
$indexUrl = ['topic/index'];
$nodeUrl = ['topic/node', 'name'=>$model['node']['ename']];
?>
<div class="box" id="new">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?></div>
<?=$this->render('_form', ['model' => $model,'content' => $content,'action' => 'edit',]); ?>
</div>
<?=$this->render('@app/views/common/tips'); ?></div>