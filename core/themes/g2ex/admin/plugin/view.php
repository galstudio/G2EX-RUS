<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$settings = Yii::$app->params['settings'];
$title = 'Плагин ['.$plugin['pid'].']';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$session = Yii::$app->getSession();
$me = Yii::$app->getUser()->getIdentity();
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Плагины', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="box">
<div class="inner form">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tbody>
<tr>
    <td width="120" align="right"><div class="sep10"></div>ID:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['pid']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>Название:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['name']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>Версия:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['version']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>Автор:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['author']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>URL:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['url']; ?><div class="sep10"></div></td>
</tr>
<tr>
    <td width="120" align="right"><div class="sep10"></div>Описание:<div class="sep10"></div></td>
    <td width="auto" align="left"><div class="sep10"></div>&nbsp;&nbsp;<?=$plugin['description']; ?><div class="sep10"></div></td>
</tr>
<tr>
<td width="120" align="right">&nbsp;&nbsp;</td>
<td width="auto" align="left" colspan="2">&nbsp;&nbsp;<?php
	if( $plugin['installed'] == false ) {
		echo Html::a('Установить', ['install', 'pid'=>$plugin['pid']], ['class'=>'super normal button']);
	} else {
		empty($plugin['settings'])?'':Html::a('Настройки', ['settings', 'pid'=>$plugin['pid']], ['class'=>'super normal button']).' ';
		echo Html::a('Удалить', ['uninstall', 'pid'=>$plugin['pid']], ['class'=>'super normal button']);
	}
?></td>
</tr>
</tbody></table>
<div class="sep10"></div>
</div>
</div>
</div></div>
