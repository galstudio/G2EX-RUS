<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Siteinfo;
$siteinfo = Siteinfo::getSiteInfo();
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><span class="fade">Статистика</span></div>
    <div class="cell">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="50" align="right"><span class="gray">Темы:</span></td>
                <td width="auto" align="left"><strong><?=$siteinfo['nodes'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">Пользователи:</span></td>
                <td width="auto" align="left"><strong><?=$siteinfo['users'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">Топики:</span></td>
                <td width="auto" align="left"><strong><?=$siteinfo['topics'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">Комментарии:</span></td>
                <td width="auto" align="left"><strong><?=$siteinfo['comments'];?></strong></td>
            </tr>
        </tbody></table>
    </div>
    <div class="inner">
        <span class="chevron">›</span> <?=Html::a('рейтинг', ['top/rich']); ?> &nbsp; &nbsp;
    </div>
</div>
