<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\User;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$settings = Yii::$app->params['settings'];
$title = '社区财富排行榜';
$this->title = Html::encode($settings['site_name']).' › '.$title;
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="cell"><div class="fr" style="margin: -3px -8px 0px 0px">
<?=Html::a('账户余额', ['my/balance'],['class'=>'tab']); ?><?=Html::a('充值', ['my/add'],['class'=>'tab']); ?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title ;?></div>
<?php
if ( intval($settings['cache_enabled']) === 0 || $this->beginCache('f-top', ['duration' => intval($settings['cache_time'])*60])) :
?>
<div class="inner">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody>
<?php
$users = User::find()->innerJoinWith(['userInfo'])->where(['and','score>0','top_close=0'])->orderBy(['score'=>SORT_DESC])->limit(20)->all();foreach($users as $key=>$user) {?>
<tr>
<td width="53" valign="top" align="center">
<?=Html::a(Html::img('@web/'.str_replace('{size}', 'normal', $user['avatar']), ['class'=>'avatar lazy','border' => '0','align'=>'default']), ['user/view', 'username'=>Html::encode($user['username'])])?>
</td>
<td width="auto" align="left">
<h2 style="margin-bottom: 10px; margin-top: 0px"><span class="gray"><?=($key+1)?>.</span> <?= Html::a(Html::encode($user['username']), ['user/view', 'username'=>Html::encode($user['username'])])?> <img src="/<?=SfHtml::uGroupRank($user['score']);?>" title="<?=SfHtml::uGroup($user['score']);?>" align="absmiddle" style="max-width: 30px;max-height: 14px; "><small class="fade f12"><?=SfHtml::uGroup($user['score']);?></small></h2>
<?php if ($user['userInfo']['tagline']!=NULL) : ?><span class="gray f12"><?=Html::encode($user['userInfo']['tagline'])?></span>
<div class="sep5"></div><?php endif; ?><?php if ($user['userInfo']['website']!=NULL) : ?>
<span class="gray f12"><a href="<?=Html::encode($user['userInfo']['website'])?>" target="_blank"><?=Html::encode($user['userInfo']['website'])?></a></span>
<div class="sep5"></div><?php endif; ?>
<span class="fade">第 <?=Html::encode($user['id'])?> 号会员</span>
</td>
<td width="220" align="center">
<div class="balance_area" style="font-size: 24px; line-height: 24px;">&nbsp;<?=SfHtml::uScore($user['score']); ?>&nbsp;</div>
</td>
</tr>
<tr>
<td colspan="3"><div style="height: 1px; background-color: #f0f0f0; border-bottom: 1px solid #fcfcfc;"></div></td>
</tr>
 <?php };
 if( !$isGuest ) {?>           
<tr>
<td colspan="3" align="center"><span class="fade">你<?php if ($myInfo->top_close >0) {echo '目前没有参与';}else{echo '当前参与了';}?>社区排行榜</span></td>
</tr>
 <?php };?>
</tbody></table>
</div>
<?php
if ( intval($settings['cache_enabled']) !== 0 ) {
    $this->endCache();
}
endif;
?>
</div>
</div>
