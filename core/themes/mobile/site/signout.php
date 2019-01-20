<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › 登出'  ;
$title = '登出';
?>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> 登录</div>
<div class="inner">
你已经完全登出，没有任何个人信息留在这台电脑上。
<div class="sep20"></div>
<input type="button" class="super normal button" onclick="location.href = '/signin';" value="重新登录">
</div>
    </div>
</div>