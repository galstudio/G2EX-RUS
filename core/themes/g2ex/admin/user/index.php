<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use app\models\User;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$title ='Пользователи';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
$currentPage = $pages->page+1;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><div class="fr" style="margin: -3px -8px 0px 0px">
<?php
foreach(User::$statusOptions as $status=>$statusName) {
$links[] = Html::a($statusName, ['index', 'status'=>$status],['class' => 'nav']);
}
echo implode('', $links);
?>
</div><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Пользователи', ['index']);?></div>
<div class="box">
<div>
<div class="cell form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?=$form->field($model, "username"); ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('Поиск', ['class' => 'super normal button', 'name' => 'login-button']); ?>
</div>
<?php ActiveForm::end();?>
</div>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="auto" align="center" class="h">ID</th>
<th width="auto" align="center" class="h">Логин</th>
<th width="auto" align="center" class="h">Email</th>
<th width="auto" align="center" class="h">Медь</th>
<th width="30" align="center" class="h">Права</th>
<th width="100" align="center" class="h">Группа</th>
<th width="150" align="center" class="h" style="border-right: none;">Действия</th>
</tr>
<?php
foreach($users as $user) {
    echo '<tr><td  align="center" class="d">', $user['id'],'</td><td align="center" class="d">', SfHtml::uLink(Html::encode($user['username'])),'</td><td align="center" class="d">', $user['email'],'</td><td align="center" class="d">', $user['score'],'</td><td align="center" class="d">', $user['role'],'</td><td align="center" class="d"><img src="/', SfHtml::uGroupRank($user['score']),'" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"> ', SfHtml::uGroup($user['score']),'</td><td align="center" class="d" style="border-right: none;">';
    if ($user['status']<10) {echo Html::a('Активировать', ['activate', 'id'=>$user['id']],['class' => 'super normal button']),' ';}echo Html::a('Инфо', ['admin/user/info', 'id'=>$user['id']], ['class'=>'super normal button']),' ',Html::a('Правка', ['admin/user/charge', 'to'=>$user['username']], ['class'=>'super normal button']), '</td></tr>';
}?>
</tbody></table>
<?php if($pages->pagecount > 1) {?>
<div class="cell">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="80%" align="left">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>10,'prevPageLabel'=>false,'nextPageLabel'=>false]);?>
<?php if ($currentPage!==$pages->pagecount){;?>
<div class="pagination"><li><span class="fade"> ... </span></li><li><a href="?p=<?=$pages->pagecount;?>" class="page_normal"><?=$pages->pagecount;?></a></li></div><?php ;};?>
&nbsp;
<input type="number" class="page_input" autocomplete="off"  value="<?=$currentPage;?>" min="1" max="<?=$pages->pagecount;?>" onkeydown="if (event.keyCode == 13)location.href = '?p=' + this.value">
</td>
<td width="20%" align="right">
<div class="fr">
<?=LinkPager::widget(['pagination' => $pages,'maxButtonCount'=>0,'nextPageLabel'=>'<i class="iconfont icon-chevronright"></i>','prevPageLabel'=>'<i class="iconfont icon-chevronleft"></i>']);?></div>
</td>
</tr>
</table>
</div>
<?php ;};?>
</div>
</div>
</div>
</div>
