<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Ad;
$formatter = Yii::$app->getFormatter();
?>
<?php
$ads = Ad::getAds();
if( !empty($ads) ):
foreach($ads as $ad) {if($formatter->asDateTime(time(), 'y-MM-dd') < $ad['expires']){?>
<div class="sep20"></div>
<div class="box">
 <?=$ad['content']?>
</div>
<?php }} endif;?>