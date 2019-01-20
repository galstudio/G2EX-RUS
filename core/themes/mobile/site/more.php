<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
$settings = Yii::$app->params['settings'];
$isGuest = Yii::$app->getUser()->getIsGuest();
$this->title = Html::encode($settings['site_name']);
$title = 'More';
?>
<div class="box">
    <div class="inner">搜索全站主题
    <div class="sep5"></div>
    <form action="<?=Url::to(['topic/search']);?>" method="get">
    <input type="text" class="sl" name="q" id="q" style="width: 280px; display: block; margin-left: 2px; border: 1px solid #ddd; box-shadow: none;">
    <div class="sep5"></div>
    <input type="submit" value="提交" class="super normal button">
    </form>
    </div>
</div>
<?php if(!$isGuest){?>
<div class="sep5"></div>
<div class="box">
    <div class="inner">
    &nbsp; › &nbsp; <?=Html::a('登出', ['site/signout'], ['data'=>['confirm' => '确实要从'.$settings['site_name'].'登出?','method' => 'post'],'class'=>'top']); ?>
    </div>
</div><?php }?>