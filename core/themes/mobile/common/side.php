<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
?>
<div class="sep5"></div>
<div class="box">
<div class="cell">管理导航</div>
<div class="inner side">
<?=Html::a('基本设置', ['admin/setting'], ['class' => 'super normal button']);?>
<?=Html::a('登录设置', ['admin/setting/auth'], ['class' => 'super normal button']);?>
<?=Html::a('导航设置', ['admin/navi'], ['class' => 'super normal button']);?>
<?=Html::a('节点管理', ['admin/node'], ['class' => 'super normal button']);?>
<?=Html::a('会员管理', ['admin/user'], ['class' => 'super normal button']);?>
<?=Html::a('广告管理', ['admin/ad'], ['class' => 'super normal button']);?>
<?=Html::a('标签管理', ['admin/tag'], ['class' => 'super normal button']);?>
<?=Html::a('积分管理', ['admin/user/charge'], ['class' => 'super normal button']);?>
<?=Html::a('单页管理', ['admin/page'], ['class' => 'super normal button']);?>
<?=Html::a('链接管理', ['admin/link'], ['class' => 'super normal button']);?>
<?=Html::a('插件管理', ['admin/plugin'], ['class' => 'super normal button']);?>
<?=Html::a('邮件测试', ['admin/setting/test-email'], ['class' => 'super normal button']);?>
<?=Html::a('清空缓存', ['admin/setting/clear-cache'], ['class' => 'super normal button']);?>
</div>
</div>