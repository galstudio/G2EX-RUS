<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$session = Yii::$app->getSession();
$settings = Yii::$app->params['settings'];
$me = Yii::$app->getUser()->getIdentity();
\app\assets\Select2Asset::register($this);
$this->registerJs("$('.select2').select2();");
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$editorClass = '\app\plugins\\'. $topic['node']['editor']. '\\'. $topic['node']['editor'];
$editor = new $editorClass();
$editor->registerAsset($this);
\app\themes\g2ex\layouts\emojiAsset::register($this);
$title = '发布回复';
$this->title =Html::encode($settings['site_name']).' › '.$title;
?>
<?=$this->render('@app/views/common/login'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box" id="new">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']]); ?><span class="chevron">&nbsp;›&nbsp;</span>  <?=Html::a(Html::encode($topic['title']), ['topic/view', 'id'=>$topic['id']]); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title?></div>
<div class="cell msl" style="border-bottom:1px solid #e2e2e2;"><?=Html::encode($topic['title']); ?></div>
<?php if ( $session->hasFlash('postNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('postNG');?></div>
<?php }?>
<?php $form = ActiveForm::begin(); ?>
<?php if(Yii::$app->getUser()->getIdentity()->isAdmin()) {echo '<div class="cell">'.$form->field($comment, 'invisible')->dropDownList(['公开回复', '屏蔽回复'], ['class'=>'select2','style'=>'width: 300px; font-size: 14px; display: none;'])->label(false).'</div>';}?>
<div class="cell rc">
<?=$form->field($comment, 'content')->textArea(['id'=>'editor', 'maxlength'=>30000])->label(false);?>
</div>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton('发布回复', ['class' => 'super normal button']); ?> <span class="emotion">&nbsp;</span>
<?php if($me->canUpload($settings)) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">图片上传</div>';}?>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
<script>
autosize(document.querySelectorAll('textarea'));
</script>
