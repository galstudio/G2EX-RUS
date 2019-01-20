<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Topic;
$settings = Yii::$app->params['settings'];
$this->registerAssetBundle('app\assets\Select2Asset');
$this->registerJs('$(".access_auth").select2({placeholder:"内容查看权限",allowClear: true});');
\app\themes\g2ex\layouts\autosizeAsset::register($this);
if($model->isNewRecord){
$editorClass = '\app\plugins\\'. $model['node']['editor']. '\\'. $model['node']['editor'];
$editor = new $editorClass();
}else{
$editorClass = '\app\plugins\\'. $model['editor']. '\\'. $model['editor'];
$editor = new $editorClass();
}
$editor->registerAsset($this);
?>
<?php $form = ActiveForm::begin(); ?>
<?php
if( $action === 'edit' && Yii::$app->getUser()->getIdentity()->isAdmin()) {
echo '<div class="cell">','<div class="ckbox">', $form->field($model, 'invisible')->checkbox(), '</div>','<div class="ckbox">', $form->field($model, 'comment_closed')->checkbox(), '</div>','<div class="ckbox">', $form->field($model, 'star')->checkbox(), '</div>','<div class="ckbox">', $form->field($model, 'alltop')->checkbox(), '</div>','<div class="ckbox">', $form->field($model, 'top')->checkbox(), '</div>','</div>';}?>
<?php 
if($model->isNewRecord){
echo $form->field($model, 'editor')->hiddenInput(['value'=>$model['node']['editor']])->label(false);
}else{
echo $form->field($model, 'editor')->hiddenInput(['value'=>$model['editor']])->label(false);
} ?>
<div class="cell">
<?=$form->field($model, 'title')->textArea(['rows' => '1','placeholder'=>'标题','class'=>'sll', 'id'=>'topic_title','maxlength'=>120])->label(false); ?>
<?=$form->field($content, 'content')->textArea(['id'=>'editor','class'=>'mll','placeholder'=>'正文' ,'autofocus'=>'autofocus', 'maxlength'=>30000])->label(false); ?>
<div class="sep5"></div>
<?=$form->field($model, 'access_auth')->dropDownList(Topic::$access, ['class'=>'access_auth','style'=>'width: 100%; font-size: 14px; display: none;'])->label(false); ?>
</div>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton($model->isNewRecord ? '发布主题' : '编辑主题', ['class' => 'super normal button']); ?>
<?php if( Yii::$app->getUser()->getIdentity()->canUpload($settings) ) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">上传图片</div>';}?>
</div>
<?php ActiveForm::end(); ?>
<script>
autosize(document.querySelectorAll('textarea'));
</script>