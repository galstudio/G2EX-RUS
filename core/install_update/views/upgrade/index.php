<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › 系统升级';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']) , ['/']), '<span class="chevron">&nbsp;›&nbsp;</span>系统升级';?></div>
<div class="problem">请先备份网站程序，并备份数据库数据。本站不对升级过程中造成的程序或数据损失等负责。 </div>
<div class="cell"><?php echo Html::a('已备份，开始升级', ['v115to120'],['class' => 'super normal button']); ?></div>
</div>
</div>