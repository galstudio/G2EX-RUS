<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Navi;
use app\models\Node;
use app\models\Siteinfo;
$siteinfo = Siteinfo::getSiteInfo();
$settings = Yii::$app->params['settings'];
$title = 'Planes';
$this->title = Html::encode($settings['site_name']).' › '.$title;
?>
<div class="box">
<?=$this->render('@app/views/common/login'); ?>
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title;?></div>
<p style="text-align:center"><?=$siteinfo['nodes'];?> nodes now and growing.</p>
</div>
<?php
if ( intval($settings['cache_enabled']) ===0 || $this->beginCache('f-all-nodes', ['duration' => intval($settings['cache_time'])*60])) :
?>
<?php $navis = Navi::getAllNaviNodes();foreach($navis as $cNavi) :?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::encode($cNavi['name']); ?><span class="fr fade"><?=Html::encode($cNavi['ename']); ?> • <span class="small"><?=count($cNavi['naviNodes']); ?> nodes</span></span></div>
<div class="inner">
<?php foreach($cNavi['naviNodes'] as $cNode) {$cNode = $cNode['node'];echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']], ['class'=>'item_node']);}?>
</div>
</div>
<?php endforeach;$nodes = Node::getNodesWithoutNavi();?>
<div class="sep5"></div>
<div class="box">
<div class="header">未分类节点<span class="fr fade"><span class="small"><?=count($nodes); ?> nodes</span></span></div>
<div class="inner">
<?php
foreach($nodes as $cNode) {echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']], ['class'=>'item_node']);}?>
</div>
</div>
<?php if ( intval($settings['cache_enabled']) !== 0 ) {$this->endCache();}endif;?>
</div>