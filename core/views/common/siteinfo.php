<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Siteinfo;
$siteinfo = Siteinfo::getSiteInfo();
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell"><span class="fade">社区运行状况</span></div>
    <div class="cell">
        <table cellpadding="5" cellspacing="0" border="0" width="100%">
            <tbody><tr>
                <td width="50" align="right"><span class="gray">节点</span></td>
                <td width="auto" align="left"><strong><?php echo $siteinfo['nodes'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">注册会员</span></td>
                <td width="auto" align="left"><strong><?php echo $siteinfo['users'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">主题</span></td>
                <td width="auto" align="left"><strong><?php echo $siteinfo['topics'];?></strong></td>
            </tr>
            <tr>
                <td width="50" align="right"><span class="gray">回复</span></td>
                <td width="auto" align="left"><strong><?php echo $siteinfo['comments'];?></strong></td>
            </tr>
        </tbody></table>
    </div>
    <div class="inner">
        <span class="chevron">›</span> <?php echo Html::a('财富排行榜', ['top/rich']); ?> &nbsp; &nbsp;
    </div>
</div>