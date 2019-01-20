<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Ad;
$formatter = Yii::$app->getFormatter();
?>
<?php
$ads = Ad::getAds();
if( !empty($ads) ):
foreach($ads as $ad) {if($ad['location']==0 && $formatter->asDateTime(time(), 'y-MM-dd') < $ad['expires']){?>
<div class="sep20"></div>
<div class="box">
    <div class="cell">
        <?php echo Html::encode($ad['name'])?>
    </div>
    <div class="dock_area">
        <div class="inner">
         <?php echo $ad['content']?>
        </div>
    </div>
</div>
<?php }} endif;?>