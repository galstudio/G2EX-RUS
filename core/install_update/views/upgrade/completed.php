<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2016 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › 升级完成';
?>
</div>
<div id="Main" style="margin: 0px 20px 0px 20px;">
<div class="sep20"></div>
<div class="box">
<div class="header"><?php echo Html::a(Html::encode($settings['site_name']) , ['/']), '<span class="chevron">&nbsp;›&nbsp;</span>升级完成';?></div>
<div class="problem">升级完成！ </div>
<div class="cell"><?php echo Html::a('登录管理后台更新论坛配置', ['/admin/setting/clear-cache'],['class' => 'super normal button']); ?></div>
</div>
</div>