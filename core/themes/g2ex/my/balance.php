<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\History;
use app\components\SfHtml;
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › Баланс';
$session = Yii::$app->getSession();
$formatter = Yii::$app->getFormatter();
$me = Yii::$app->getUser()->getIdentity();
$currentPage = $pages->page+1;
$types = [
    History::ACTION_REG => 'Регистрация',
    History::ACTION_ADD_TOPIC => 'Топик',
    History::ACTION_ADD_COMMENT => 'Комментарий',
    History::ACTION_COMMENTED => 'Комментарий',
    History::ACTION_ORIGINAL_SCORE => 'Ссуда',
    History::ACTION_SIGNIN => 'Вход',
    History::ACTION_SIGNIN_10DAYS => 'Постоянство',
    History::ACTION_INVITE_CODE => 'Инвайт',
    History::ACTION_MSG => 'Сообщение',
    History::ACTION_GOOD_TOPIC => 'Благодарность',
    History::ACTION_GOOD_COMMENT => 'Оценка',
    History::ACTION_TOPIC_THANKED => 'Благодарность',
    History::ACTION_COMMENT_THANKED => 'Благодарность',
    History::ACTION_CHARGE_POINT => 'Премия',
];

function getComment($action, $ext) {
    $str = '';
    if( $action == History::ACTION_ADD_TOPIC ) {
        $str = 'Создан топик › «' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_ADD_COMMENT ) {
        $str = 'Добавлен комментарий в › «' . Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_ORIGINAL_SCORE ) {
        $str = 'Получен начальный капитал ' . $ext['cost'];
    } else if( $action == History::ACTION_COMMENTED ) {
        $str = Html::a(Html::encode($ext['commented_by']), ['user/view', 'username'=>$ext['commented_by']]) . ' оставил комментарий в › «'. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_SIGNIN ) {
        $str = 'Ежедневный бонус за вход ' . $ext['cost'] . ' медных монет';
    } else if( $action == History::ACTION_SIGNIN_10DAYS ) {
        $str = 'За вход в течении 10 дней ' . $ext['cost'] . ' медных монет';
    } else if( $action == History::ACTION_INVITE_CODE ) {
        $str = 'Покупка за ' . $ext['amount'] . ' золотых инвайта';
    } else if( $action == History::ACTION_REG ) {
        $str = 'Регистрация в системе ' . $ext['cost'] . ' медных монет';
    }  else if( $action == History::ACTION_MSG ) {
        $str = 'Отправил сообщение ' . Html::a(Html::encode($ext['target']), ['user/view', 'username'=>$ext['target']]);
    }else if( $action == History::ACTION_GOOD_TOPIC ) {
        $str = 'Поблагодарил '.SfHtml::uLink($ext['thank_to']).' за топик › «'. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_GOOD_COMMENT ) {
        $str = 'Оценил комментарий в '.SfHtml::uLink($ext['thank_to']).' › «'. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_TOPIC_THANKED ) {
        $str = 'Благодарность от '. SfHtml::uLink($ext['thank_by']).' за топик › «'. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '»';
    } else if( $action == History::ACTION_COMMENT_THANKED ) {
        $str = SfHtml::uLink($ext['thank_by']).' поблагодарил в «'. Html::a(Html::encode($ext['title']), ['topic/view', 'id'=>$ext['topic_id']]) . '» за комментарий';
    } else if( $action == History::ACTION_CHARGE_POINT ) {
        $str = 'Премия ' . $ext['cost'] . ' медных монет от администрации: '. Html::encode($ext['msg']);
    }
    return $str;
}
function getCostName($cost) {
    $cost = intval($cost);
    $color = $cost>0?'positive':'negative';
    return '<span class="' . $color . '"><strong>' . $cost . '</strong></span>';
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="cell"><div class="fr" style="margin: -3px -8px 0px 0px">
<?=Html::a('Рейтинг', ['top/rich'],['class'=>'tab']); ?><?=Html::a('Пополнить баланс', ['my/add'],['class'=>'tab']); ?></div><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> Остаток на счете</div>
<div class="cell">
    <table cellpadding="10" cellspacing="0" border="0" width="100%">
        <tbody><tr>
            <td width="200">
            <span class="gray">Сальдо текущего баланса</span>
            <div class="sep10"></div>
            <div class="sep5"></div>
            <div class="balance_area" style="font-size: 24px; line-height: 24px;"><?=SfHtml::uScore($me->score); ?></div></td><?php if ( intval(Yii::$app->params['settings']['close_register']) === 2 ) {;?>
             <td width="100"><span class="fr"><?=Html::a('购买邀请码', ['service/buy-invite-code'],['class' => 'super normal button']); ?></span></td><?php };?>
        </tr>
    </tbody></table>
</div>
<?php if ( $session->hasFlash('RegNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('RegNG');?></div>
<?php } else if ( $session->hasFlash('RegOK') ) {?>
<div class="message" onclick="$(this).slideUp('fast');"><?=$session->getFlash('RegOK');?></div>
<?php }?>
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
<div>
    <table cellpadding="5" cellspacing="0" border="0" width="100%" class="data">
        <tbody><tr>
            <td width="130" class="h">Дата/Время</td>
            <td width="100" class="h">Тип</td>
            <td width="60" class="h">Сумма</td>
            <td width="60" class="h">Баланс</td>
            <td width="auto" class="h" style="border-right: none;">Описание</td>
        </tr>
<?php
foreach($records as $record) {
    $ext = json_decode($record['ext'], true);
    echo '<tr>',
            '<td class="d"><small class="gray">', $formatter->asDateTime($record['action_time'], 'dd.MM.y HH:mm:ss xxx'), '</td>',
            '<td class="d">', $types[$record['action']], '</td>',
            '<td class="d" style="text-align: right;">', getCostName($ext['cost']), '</td>',
            '<td class="d" style="text-align: right;">', $ext['score'], '</td>',
            '<td class="d" style="border-right: none;"><span class="gray">', getComment($record['action'], $ext), '</span></td>',
         '</tr>';
}
?>
    </tbody></table>
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
</div>
<?php if ( $me->reg==0 ) {?>
<div class="sep20"></div>
<div class="box">
    <div class="header">Справка</div>
    <div class="inner">
        <h2>Как получить начальный капитал?</h2>
        Добро пожаловать в <?=Html::encode($settings['site_name'])?>! При авторизации в системе вы получаете 1000 медных монет. Все ваши действия в сообществе, в том числе создания тем, топиков,  комментариев и т.д., будут стоить меди. Когда вы опубликовали что-то стоящее, вы будете зарабатывать медь, ну и хорошее настроение :)
        <div class="sep20"></div>
        <strong>Выполните задание:</strong>
        <div class="sep10"></div>
        Создать новый топик.
        <div class="sep10"></div>
        <strong>Награда за задание</strong>
        <div class="sep10"></div>
        <div class="balance_area" style="">10 <img src="/static/images/silver.png" alt="S" align="absmiddle" border="0" style="padding-bottom: 2px;"> </div>
        <div class="sep20"></div>
        <input type="button" onclick="location.href = '/mission/complete';" value="Выполнено" class="super normal button" data-method="post">
    </div>
</div>
<?php }?>
</div>
