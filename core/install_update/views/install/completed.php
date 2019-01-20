<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › Установка завершена';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Установка завершена</div>
<div class="message">Поздравляем, становка завершена. Перейдите в админпанель для настройки системы..<?php echo Html::a('в админпанель', ['/admin/setting/all'],['class' => 'super normal button']); ?></div>
</div>
</div>
