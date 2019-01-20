<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$title = 'Мои темы';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Мои темы<div class="fr f12"><span class="snow">Всего тем:&nbsp;</span> <strong class="gray"><?=$pages->totalCount;?></strong></div></div>
<div style="text-align: left; background-color: #f9f9f9;">
<?php
foreach($nodes as $node) {
    echo Html::a('<div style="display: table; padding: 20px 0px 20px 0px; width: 100%; text-align: center; font-size: 14px;"><img src="/'.Html::encode($node['node']['icon']).'" border="0" align="default" width="auto" height="60" style="max-width:130px;"><div class="sep10"></div>'.Html::encode($node['node']['name']).'<div class="sep5"></div><span class="fade f12">Топиков: '.Html::encode($node['node']['topic_count']).'</span></div>', ['topic/node', 'name'=>$node['node']['ename']],['class'=>'grid_item']);
}?>
</div>
</div>
</div>
