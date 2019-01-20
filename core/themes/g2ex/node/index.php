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
$title = 'Планы';
$this->title = Html::encode($settings['site_name']).' › '.$title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title;?></div>
<p style="text-align:center">В данный момент в системе <?=Yii::t('app', '{n, plural, one{# тема} few{# темы} many{# тем} other{# темы}}', ['n' => $siteinfo['nodes']]);?>, но скоро будет больше…</p>
</div>
<?php
if ( intval($settings['cache_enabled']) ===0 || $this->beginCache('f-all-nodes', ['duration' => intval($settings['cache_time'])*60])) :
?>
<?php $navis = Navi::getAllNaviNodes();foreach($navis as $cNavi) :?>
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::encode($cNavi['name']); ?><span class="fr fade"><?=Html::encode($cNavi['ename']); ?> • <span class="small"><?=Yii::t('app', '{n, plural, one{# тема} few{# темы} many{# тем} other{# темы}}', ['n' => count($cNavi['naviNodes'])]); ?></span></span></div>
<div class="inner">
<?php foreach($cNavi['naviNodes'] as $cNode) {$cNode = $cNode['node'];echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']], ['class'=>'item_node']);}?>
</div>
</div>
<?php endforeach;$nodes = Node::getNodesWithoutNavi();?>
<div class="sep20"></div>
<div class="box">
<div class="header">Темы без классификации<span class="fr fade"><span class="small"><?=Yii::t('app', '{n, plural, one{# тема} few{# темы} many{# тем} other{# темы}}', ['n' => count($nodes)]); ?></span></span></div>
<div class="inner">
<?php
foreach($nodes as $cNode) {echo Html::a(Html::encode($cNode['name']), ['topic/node', 'name'=>$cNode['ename']], ['class'=>'item_node']);}?>
</div>
</div>
<?php if ( intval($settings['cache_enabled']) !== 0 ) {$this->endCache();}endif;?>
</div>
