<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Topic;
$settings = Yii::$app->params['settings'];
?>
<?php
$hotTopics = Topic::getHotTopics();
if( !empty($hotTopics) ):
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><span class="fade">本月热议主题</span></div>
<?php foreach($hotTopics as $ht) {?>
    <div class="cell node_ hot_t_<?php echo $ht['id']?>">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
    <td width="24" valign="middle" align="center">
    <?php echo Html::a(Html::img('@web/'.str_replace('{size}', 'small', $ht['author']['avatar']), ['class'=>'avatar','border'=>'0','align' => 'default','style'=>'max-width: 24px; max-height: 24px;']), ['user/view', 'username'=>Html::encode($ht['author']['username'])]);?>
    </td>
    <td width="10"></td>
    <td width="auto" valign="middle">
        <span class="item_hot_topic_title">
        <?php echo Html::a(Html::encode($ht['title']), ['topic/view', 'id'=>$ht['id']]);?>
        </span>
    </td>
    </tr>
    </table>
    </div>
<?php }?>
</div>
<?php
    endif;
?>