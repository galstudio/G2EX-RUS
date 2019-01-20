<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$settings = Yii::$app->params['settings'];
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$editorClass = '\app\plugins\\'. $settings['editor']. '\\'. $settings['editor'];
$editor = new $editorClass();
$editor->registerAsset($this);
\app\themes\g2ex\layouts\emojiAsset::register($this);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="cell"><div class="fr fade" id="title_remaining">120</div>单页名</div>
<div class="cell" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'name')->textArea(['rows' => '1','class'=>'msl', 'maxlength'=>20])->label(false); ?>
</div>
<div class="cell"><div class="fr fade" id="title_remaining">120</div>单页英文名</div>
<div class="cell" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'ename')->textArea(['rows' => '1','class'=>'msl', 'maxlength'=>20])->label(false); ?>
</div>
<div class="cell"><div class="fr fade" id="content_remaining">20000</div>正文 <span class="emotion">&nbsp;</span></div>
<div class="mc"><?=$form->field($model, 'content')->textArea(['id'=>'editor','class'=>'msl','autofocus'=>'autofocus', 'maxlength'=>30000])->label(false); ?></div>
<div class="cell"><div class="fr fade">如果是跳转链接，请输入网址。</div>链接</div>
<?=$form->field($model, 'url')->textInput(['maxlength' => 100,'class'=>'msl'])->label(false); ?>
<div class="cell"><div class="fr fade">数字越小越靠前，默认99</div>排序</div>
<?=$form->field($model, 'sortid')->textInput(['maxlength' => 2,'class'=>'msl'])->label(false); ?>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton($model->isNewRecord ? '创建' : '编辑', ['class' => 'super normal button']); ?>
<?php if( Yii::$app->getUser()->getIdentity()->canUpload($settings) ) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">图片上传</div>';}?>
</div>
<?php ActiveForm::end(); ?>
<script>
autosize(document.querySelectorAll('textarea'));
</script>