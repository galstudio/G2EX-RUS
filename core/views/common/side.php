<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
?>
<div class="sep20"></div>
<div class="box">
<div class="cell">管理导航</div>
<div class="inner">
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
<td width="auto" align="center"><?php echo Html::a('基本设置', ['admin/setting'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?php echo Html::a('清空缓存', ['admin/setting/clear-cache'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?php echo Html::a('导航设置', ['admin/navi'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?php echo Html::a('节点管理', ['admin/node'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?php echo Html::a('会员管理', ['admin/user'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?php echo Html::a('广告管理', ['admin/ad'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?php echo Html::a('单页管理', ['admin/page'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?php echo Html::a('链接管理', ['admin/link'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?php echo Html::a('邮件测试', ['admin/setting/test-email'], ['class' => 'super normal button']);?></td>
</tr>
</table>
</div>
</div>