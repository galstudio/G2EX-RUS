<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Link;
?>
<?php
$links = Link::getLinks();
if( !empty($links) ):
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><span class="fade">Ссылки</span></div>
    <div class="inner">
    <?php
    foreach($links as $link) {
        echo Html::a('<span class="chevron">›</span> '.Html::encode($link['name']).'<div class="sep5"></div>', $link['url'], ['target'=>'_blank', 'rel' => 'external']);
    }?>
    </div>
</div>
<?php
    endif;
?>
