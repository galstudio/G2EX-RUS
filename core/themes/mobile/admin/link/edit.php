<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
$title ='修改链接';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?php echo $this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?php echo Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('链接管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="inner form">
<?php echo $this->render('_form', ['model' => $model, 'type'=>'edit']); ?>
	</div>
</div>
</div>