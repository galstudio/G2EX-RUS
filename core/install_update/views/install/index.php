<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

extract($check->result);

$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › Проверка окружения';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']) , ['/']), '<span class="chevron">&nbsp;›&nbsp;</span>Проверка сервера';?></div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th colspan="3"  class="h" style="border-right: none;">Сервер</th>
</tr>
<tr>
<td colspan="3"  class="d" style="border-right: none;"><?php echo $check->getServerInfo() . ' ' . $check->getNowDate() ?></td>
</tr>
<tr>
<th colspan="3" class="h" style="border-right: none;">Результаты</th>
</tr>
</tbody>
</table>
<?php if ($summary['errors'] > 0): ?>
<div class="problem">
<strong>Ваш сервер не соответствует требованиям, подробности см ниже</strong>
</div>
<?php elseif ($summary['warnings'] > 0): ?>
<div class="message">
<?php if ($summary['errors'] == 0) {Yii::$app->getSession()->set('install-step', 1);echo Html::a('Далее', ['db-setting'], ['class'=>'fr super normal button']);}?><div class="sep5"></div>
<strong>Ваш сервер соответствует наиболее основным требованиям системы</strong>
</div>
<?php else: ?>
<div class="message">
<?php if ($summary['errors'] == 0) {Yii::$app->getSession()->set('install-step', 1);echo Html::a('Далее', ['db-setting'], ['class'=>'fr super normal button']);}?><div class="sep5"></div><strong>Поздравляем, требования системы к серверу выполнены.</strong>
</div>
<?php endif; ?>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th class="h">Требуется</th>
<th class="h">Статус</th>
<th class="h" style="border-right: none;">Описание</th>
</tr>
<?php foreach ($requirements as $requirement): ?>
<tr class="<?php echo $requirement['condition'] ? 'green' : ($requirement['mandatory'] ? 'negative' : 'blue') ?>">
<td class="d">
<?php echo $requirement['name'] ?>
</td>
<td class="d">
<span class="result"><?php echo $requirement['condition'] ? 'да' : ($requirement['mandatory'] ? 'нет' : 'предупреждение') ?></span>
</td>
<td class="d" style="border-right: none;">
<?php echo $requirement['memo'] ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
