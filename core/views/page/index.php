<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
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
<?php echo $this->render('@app/views/common/login'); ?>
<?php echo $this->render('@app/views/common/ad'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="cell"><span class="fade"><?php echo Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?php echo Html::encode($page['name']); ?></span></div>
<div class="inner">
<div class="page markdown_body">
<?php echo $editor->parse($page['content'])?>
</div>
</div>
</div>
</div>
<script>
hljs.initHighlightingOnLoad();
</script>