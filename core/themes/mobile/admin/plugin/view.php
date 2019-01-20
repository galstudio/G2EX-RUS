<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$settings = Yii::$app->params['settings'];
$title = '插件['.$plugin['pid'].']详细介绍';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
?>
<?php echo $this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?php echo Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('插件管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="inner form">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
    <td width="120" align="right"><div class="sep10"></div>插件ID<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['pid']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>插件名<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['name']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>版本<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['version']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>作者<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['author']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>网址<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['url']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>描述<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?php echo $plugin['description']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">&nbsp;&nbsp;</td>
<td width="auto" align="left" colspan="2">&nbsp;&nbsp;<?php
	if( $plugin['installed'] == false ) {
		echo Html::a('安装', ['install', 'pid'=>$plugin['pid']], ['class'=>'super normal button']);
	} else {
		empty($plugin['settings'])?'':Html::a('配置', ['settings', 'pid'=>$plugin['pid']], ['class'=>'super normal button']).' ';
		echo Html::a('卸载', ['uninstall', 'pid'=>$plugin['pid']], ['class'=>'super normal button']);
	}
?></td>
</tr>
</tbody></table>
<div class="sep10"></div>
</div>
</div>
</div>