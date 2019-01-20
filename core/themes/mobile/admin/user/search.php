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
$title ='搜索会员';
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('会员管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?>
<div style="margin:5px"><?=Html::a('正常会员', ['index', 'status'=>User::STATUS_ACTIVE],['class' => 'nav']),Html::a('待激活会员', ['index', 'status'=>User::STATUS_INACTIVE],['class' => 'nav']),Html::a('待验证会员', ['index', 'status'=>User::STATUS_ADMIN_VERIFY],['class' => 'nav']),Html::a('屏蔽会员', ['index', 'status'=>User::STATUS_BANNED],['class' => 'nav']); ?></div>
</div>
<div class="box">
<div>
<div class="cell form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?=$form->field($model, "username"); ?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('搜索用户', ['class' => 'super normal button', 'name' => 'login-button']); ?>
</div>
<?php ActiveForm::end();?>
</div>
<table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
<tbody>
<tr>
<th width="20" align="center" class="h">ID</th>
<th width="auto" align="center" class="h">会员</th>
<th width="auto" align="center" class="h">铜币</th>
<th width="35" align="center" class="h">权限</th>
<th width="40" align="center" class="h">会员组</th>
<th width="35" align="center" class="h" style="border-right: none;">操作</th>
</tr>
<?php
if( !empty($user) ) {
echo '<tr><td align="center" class="d">', $user['id'],'</td><td align="center" class="d">', SfHtml::uLink(Html::encode($user['username'])),'</td><td align="center" class="d">', $user['score'],'</td><td align="center" class="d">', $user['role'],'</td><td align="center" class="d"><img src="/', SfHtml::uGroupRank($user['score']),'" align="absmiddle" style="max-width: 30px;max-height: 14px; margin-bottom: 4px"></td><td align="center" class="d" style="border-right: none;">';
    if ($user['status']<10) {echo Html::a('激活', ['activate', 'id'=>$user['id']],['class' => 'super normal button']),'<br><br>';}echo Html::a('管理', ['admin/user/info', 'id'=>$user['id']], ['class'=>'super normal button']),'<br><br> ',Html::a('充值', ['admin/user/charge', 'to'=>$user['username']], ['class'=>'super normal button']), '</td></tr>';
} else {echo '<tr><td width="auto" align="center" colspan="7"><small class="red">搜索的用户不存在</small></td></tr>';};?>
</tbody></table>
</div>
</div>
</div>
</div>
