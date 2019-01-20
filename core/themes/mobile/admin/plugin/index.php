<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
$settings = Yii::$app->params['settings'];
$title ='插件管理';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('插件管理', ['index']);?></div>
<div class="box">
<div class="cell"><?=Html::a('可安装插件', ['installable'],['class'=>'super normal button']); ?></div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="20" align="center" class="h">插件ID</th>
<th width="auto" align="center" class="h">插件名</th>
<th width="40" align="center" class="h">版本</th>
<th width="50" align="center" class="h" style="border-right: none;">操作</th>
</tr>
<?php
    foreach($plugins as $plugin) {
        echo '<tr><td align="center" class="d">', $plugin['pid'], '</td>
			<td align="center" class="d">', Html::a(Html::encode($plugin['name']), ['view', 'pid'=>$plugin['pid']]), '</td>
			<td align="center" class="d">', Html::encode($plugin['version']) ,'</td><td align="center" height="20" class="d" style="border-right: none;">', 
            empty($plugin['settings'])?'':Html::a('配置', ['settings', 'pid'=>$plugin['pid']],['class' => 'super normal button']).'<br><br>', 
            Html::a('卸载', ['uninstall', 'pid'=>$plugin['pid']],['class' => 'super normal button'], [
                'data' => [
                    'confirm' => '注意：请确认已经修改与此插件相关联的论坛配置！'."\n".'否则有可能会造成论坛出错。',
                    'method' => 'post',
            ]]), '</td>
		</tr>';
    }
?>
</tbody></table>
</div>
</div>