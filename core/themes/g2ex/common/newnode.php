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
    <div class="cell"><div class="fr"></div><span class="fade">Новые темы</span></div>
    <div class="cell">
    <?php
$newNodes = Node::getNewNodes();
foreach($newNodes as $nn) {
    echo Html::a(Html::encode($nn['name']), ['topic/node', 'name'=>$nn['ename']],['class'=>'item_node']);
}?>
    </div>
</div>
