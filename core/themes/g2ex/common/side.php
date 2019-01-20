<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
?>
<div class="sep20"></div>
<div class="box">
<div class="cell">Меню управления</div>
<div class="inner">
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
<td width="auto" align="center"><?=Html::a('Настройки', ['admin/setting'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Авторизация', ['admin/setting/auth'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Навигация', ['admin/navi'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Темы', ['admin/node'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Сообщество', ['admin/user'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Реклама', ['admin/ad'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Теги', ['admin/tag'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Права', ['admin/user/charge'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Страницы', ['admin/page'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Ссылки', ['admin/link'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Плагины', ['admin/plugin'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"><?=Html::a('Тест email', ['admin/setting/test-email'], ['class' => 'super normal button']);?></td>
</tr>
<tr>
<td width="auto" align="center"><?=Html::a('Кэш', ['admin/setting/clear-cache'], ['class' => 'super normal button']);?></td>
<td width="auto" align="center"></td>
</tr>
</table>
</div>
</div>
