<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']).' › Выход'  ;
$title = 'Выход';
?>
<?=$this->render('@app/views/common/login'); ?>
<?php if ( intval(Yii::$app->params['settings']['auth_enabled']) === 1 ) : ?>
<div class="sep20"></div>
<div class="box">
<div class="header">Другая авторизация</div>
<div class="cell" style="text-align: center;">
<?=\yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'],'popupMode' => false, ]);?>
</div>
</div>
<?php endif; ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Выход</div>
<div class="inner">
Вы полностью вышли из системы, какая-либо личная информация не осталась на вашем компьютере.
<div class="sep20"></div>
<input type="button" class="super normal button" onclick="location.href = '/signin';" value="Войти снова"
</div>
    </div>
</div>
