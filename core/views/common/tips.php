<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell">发帖提示</div>
    <div class="inner">
        <ul style="margin-top: 0px;">
            <li><span class="f13">主题标题</span><div class="sep10"></div>
            请在标题中描述内容要点。如果一件事情在标题的长度内就已经可以说清楚，那就没有必要写正文了。
            <div class="sep10"></div>
            </li>
            <li><div class="fr" style="margin-top: -5px; margin-right: 5px;"><img src="/static/images/markdown.png" border="0" width="32"></div><span class="f13">正文</span><div class="sep10"></div>
            可以在正文中为你要发布的主题添加更多细节。<?php echo Html::encode($settings['site_name']);?> 支持 Markdown 文本标记语法。
            <div class="sep10"></div>
            在正式提交之前，你可以点击编辑器右上角的 <i class="icon-preview icon-block" style="float:none"></i> 来查看 Markdown 正文的实际渲染效果。
            <div class="sep10"></div>
            </li>
            <li><span class="f13">选择节点</span><div class="sep10"></div>
            在最后，请为你的主题选择一个节点。恰当的归类会让你发布的信息更加有用。 <div class="sep10"></div></li>
            <li><span class="f13">填写标签</span><div class="sep10"></div>
            请为你的主题填写TAG标签。合适的标签会让你发布的信息更容易被集合。
            <div class="sep10"></div>
            你可以在主题发布后 <strong><?php echo Html::encode($settings['edit_space']); ?> 分钟</strong>内，对标题或者正文进行编辑。
            </li>
        </ul>
    </div>
</div>