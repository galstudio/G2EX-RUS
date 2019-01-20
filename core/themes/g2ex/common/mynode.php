<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Favorite;
use app\models\User;
$settings = Yii::$app->params['settings'];
$me = Yii::$app->getUser()->getIdentity();
$isGuest = Yii::$app->getUser()->getIsGuest();
if( !$isGuest ) {
    $me = Yii::$app->getUser()->getIdentity();
    $myInfo = $me->userInfo;}
?>
<?php if(!$isGuest && $myInfo->favorite_node_count>0 && $myInfo->mynodes==0){?>
<div class="sep20"></div>
<div class="box">
    <div class="inner" style="padding: 5px;">
        <div class="gray f12" style="padding: 5px;">Мои темы</div>
        <div id="MyNodes" class="ui-sortable">
<?php
$nodes = Favorite::find()->where(['type'=>1,'source_id'=>$me['id']])->limit(20)->all();
foreach($nodes as $node) {
    echo '<div class="node">';
    if (!Yii::$app->getUser()->getIsGuest() && Yii::$app->getUser()->getIdentity()->status >= User::STATUS_ACTIVE ) {echo '<div class="node_compose">';
    echo Html::a('<img src="/static/images/compose.png" align="absmiddle" border="0" width="23" height="18" alt="Добавить топик" title="Добавить в эту тему топик">', ['topic/add', 'node'=>$node['node']['ename']]);
    echo '</div>';
    };
    if ($node['node']['icon']!=NULL) {echo Html::a('<img src="/'.$node['node']['icon'].'" border="0" align="absmiddle" width="24">', ['topic/node', 'name'=>$node['node']['ename']]);};
    echo '&nbsp;';
    echo Html::a(Html::encode($node['node']['name']), ['topic/node', 'name'=>$node['node']['ename']]);
    echo '</div>';
}?>
    </div>
</div>
</div>
<?php }?>
