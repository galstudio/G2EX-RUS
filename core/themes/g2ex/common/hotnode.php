<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Node;
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><div class="fr"></div><span class="fade">Популярные темы</span></div>
    <div class="cell">
    <?php
$hotNodes = Node::getHotNodes();
foreach($hotNodes as $hn) {
    echo Html::a(Html::encode($hn['name']), ['topic/node', 'name'=>$hn['ename']],['class'=>'item_node']);
}?>
    </div>
</div>
