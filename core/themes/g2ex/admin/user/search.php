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
$title ='Поиск';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
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
</div><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Пользователи', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
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
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="50" align="center" class="h">ID</th>
<th width="100" align="center" class="h">Логин</th>
<th width="100" align="center" class="h">Email</th>
<th width="100" align="center" class="h">Медь</th>
<th width="100" align="center" class="h">Права</th>
<th width="100" align="center" class="h">Группа</th>
<th width="auto" align="center" class="h" style="border-right: none;">Действия</th>
</tr>
<?php
if( !empty($user) ) {
    echo '<tr><td width="50" align="center" class="d">', $user['id'],'</td><td width="100" align="center" class="d">', SfHtml::uLink(Html::encode($user['username'])),'</td><td width="100" align="center" class="d">', $user['email'],'</td><td width="100" align="center" class="d">', $user['score'],'</td><td width="100" align="center" class="d">', $user['role'],'</td><td width="100" align="center" class="d"><img src="/', SfHtml::uGroupRank($user['score']),'" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"> ', SfHtml::uGroup($user['score']),'</td><td width="auto" align="center" class="d" style="border-right: none;">';
    if ($user['status']<10) {echo Html::a('Активирорвать', ['activate', 'id'=>$user['id']],['class' => 'super normal button']),'&nbsp; &nbsp;';}echo Html::a('Инфо', ['admin/user/info', 'id'=>$user['id']], ['class'=>'super normal button']), '</td></tr>';
} else {echo '<tr><td width="auto" align="center" colspan="7"><small class="red">Таких пользователей не существует!</small></td></tr>';};?>
</tbody></table>
</div>
</div>
</div>
</div>
