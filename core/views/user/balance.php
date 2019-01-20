<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\History;
use app\lib\Util;

$this->title = 'Остаток на счете';
$formatter = Yii::$app->getFormatter();
$me = Yii::$app->getUser()->getIdentity();

$types = [
    History::ACTION_REG => 'Регистрация аккаунта',
    History::ACTION_ADD_TOPIC => 'Добавление топика',
    History::ACTION_ADD_COMMENT => 'Добавление комментария',
    History::ACTION_COMMENTED => '主题回复收益',
    History::ACTION_ORIGINAL_SCORE => '初始积分',
    History::ACTION_SIGNIN => 'Ежедневный бонус за вход',
    History::ACTION_SIGNIN_10DAYS => 'Последовательный вход',
    History::ACTION_INVITE_CODE => 'Покупка инвайта',
];

function getComment($action, $ext) {
    $str = '';
    if( $action == History::ACTION_ADD_TOPIC ) {
        $str = 'Добавление топика › ' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_ADD_COMMENT ) {
        $str = 'Добавление комментария › ' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_ORIGINAL_SCORE ) {
        $str = '获得初始积分 ' . $ext['cost'];
    } else if( $action == History::ACTION_COMMENTED ) {
        $str = '收到 ' . Html::a(Html::encode($ext['commented_by']), ['user/view', 'username'=>$ext['commented_by']]) . ' 的回复 › '. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]);
    } else if( $action == History::ACTION_SIGNIN ) {
        $str = '每日登录奖励 ' . $ext['cost'] . ' 积分';
    } else if( $action == History::ACTION_SIGNIN_10DAYS ) {
        $str = '连续登录每 10 天奖励 ' . $ext['cost'] . ' 积分';
    } else if( $action == History::ACTION_INVITE_CODE ) {
        $str = '购买了 ' . $ext['amount'] . ' 枚邀请码';
    } else if( $action == History::ACTION_REG ) {
        $str = '注册帐号奖励 ' . $ext['cost'] . ' 积分';
    }
    return $str;
}
function getCost($cost) {
    $cost = intval($cost);
    $color = $cost>0?'blue':'red';
    return '<span class="' . $color . '">' . $cost . '</span>';
}

?>

<div class="row">
<div class="col-md-8 sf-left">

<ul class="list-group sf-box">
    <li class="list-group-item">
    <?php echo Html::a('首页', ['topic/index']), '&nbsp;/&nbsp;', $this->title; ?>
    </li>
    <li class="list-group-item">
        <h4>当前账户余额： <?php echo Util::getScore($me->score); ?></h4>
    </li>
    <li class="list-group-item">
    <table class="table table-condensed table-bordered small">
      <thead>
        <tr>
          <th>类型/时间</th>
          <th>数额</th>
          <th>余额</th>
          <th>描述</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach($records as $record) {
    $ext = unserialize($record['ext']);
    echo '<tr>',
            '<td width="120">', $types[$record['action']], '<br />', $formatter->asDateTime($record['action_time'], 'y-MM-dd HH:mm'), '</td>',
            '<td width="50" class="text-right"><strong>', getCost($ext['cost']), '</strong></td>',
            '<td width="60" class="text-right">', $ext['score'], '</td>',
            '<td width="auto">', getComment($record['action'], $ext), '</td>',
         '</tr>';
}
?>
      </tbody>
    </table>
    </li>
    <li class="list-group-item item-pagination">
    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
    </li>

</ul>
</div>

<div class="col-md-4 sf-right">
<?php echo $this->render('@app/views/common/_right'); ?>
</div>

</div>
