<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › Обновление системы';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']) , ['/']), '<span class="chevron">&nbsp;›&nbsp;</span>Обновление системы';?></div>
<div class="problem">Пожалуйста, сначала сделайте резервную копию сайта и базы данных. Мы не несем ответственности за потерю данных, вызванную процессом обновления.</div>
<div class="cell"><?php echo Html::a('Резервное копирование, обновление', ['v115to120'],['class' => 'super normal button']); ?></div>
</div>
</div>
