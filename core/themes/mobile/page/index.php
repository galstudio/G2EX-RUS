<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use app\models\Page;
\app\themes\g2ex\layouts\highlightAsset::register($this);
$settings = Yii::$app->params['settings'];
$editorClass = '\app\plugins\\'. $settings['editor']. '\\'. $settings['editor'];
$editor = new $editorClass();
$this->title = Html::encode($settings['site_name']) . ' › '.Html::encode($page['name']) ;
?>
<div class="box">
<div class="cell"><span class="fade"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::encode($page['name']); ?></span></div>
<div class="inner">
<div class="markdown_body">
<?=$editor->parse($page['content'])?>
</div>
</div>
</div>
<script>
hljs.initHighlightingOnLoad();
</script>