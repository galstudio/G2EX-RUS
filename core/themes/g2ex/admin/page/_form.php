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
?>
<?php $form = ActiveForm::begin(); ?>
<div class="cell"><div class="fr fade" id="title_remaining">120</div>Название</div>
<div class="cell" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'name')->textArea(['rows' => '1','class'=>'msl', 'maxlength'=>20])->label(false); ?>
</div>
<div class="cell"><div class="fr fade" id="title_remaining">120</div>Алиас</div>
<div class="cell" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'ename')->textArea(['rows' => '1','class'=>'msl', 'maxlength'=>20])->label(false); ?>
</div>
<div class="cell"><div class="fr fade" id="content_remaining">20000</div>Текст страницы <span class="emotion">&nbsp;</span></div>
<div class="mc"><?=$form->field($model, 'content')->textArea(['id'=>'editor','class'=>'msl','autofocus'=>'autofocus', 'maxlength'=>30000])->label(false); ?></div>
<div class="cell"><div class="fr fade">Если внешний источник, укажите URL-адрес.</div>Ссылка</div>
<?=$form->field($model, 'url')->textInput(['maxlength' => 100,'class'=>'msl'])->label(false); ?>
<div class="cell"><div class="fr fade">Чем меньше число, тем выше, по умолчанию 99</div>Порядок</div>
<?=$form->field($model, 'sortid')->textInput(['maxlength' => 2,'class'=>'msl'])->label(false); ?>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => 'super normal button']); ?>
<?php if( Yii::$app->getUser()->getIdentity()->canUpload($settings) ) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">&nbsp;</div>';}?>
</div>
<?php ActiveForm::end(); ?>
<script>
autosize(document.querySelectorAll('textarea'));
</script>
