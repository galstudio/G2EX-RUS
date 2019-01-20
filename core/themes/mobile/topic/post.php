<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Node;
use app\models\Topic;
$settings = Yii::$app->params['settings'];
$session = Yii::$app->getSession();
$this->registerAssetBundle('app\assets\Select2Asset');
$this->registerJs('$(".nodes-select2").select2({placeholder:"请选择一个节点",allowClear: true});');
$this->registerJs('$(".access_auth").select2({});');
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$editorClass = '\app\plugins\WysibbEditor\WysibbEditor';
$editor = new $editorClass();
$editor->registerAsset($this);
$editor->registerTagItAsset($this);
\app\themes\g2ex\layouts\emojiAsset::register($this);
$title = '创作新主题';
$this->title =Html::encode($settings['site_name']).' › '.$title;
?>
<div class="box" id="new">
<?=$this->render('@app/views/common/login'); ?>
<div class="cell">
<div class="fr">
<a href="/new" class="super normal button">Markdown</a>&nbsp;&nbsp;<a href="/post" class="super normal button">UBB</a>
</div>
<?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?></div>
<?php if ( $session->hasFlash('postNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('postNG');?></div>
<?php }?>
<?php $form = ActiveForm::begin(); ?>
<?=$form->field($model, 'editor')->hiddenInput(['value'=>'WysibbEditor'])->label(false);?>
<div class="cell"><?=$form->field($model, 'title')->textArea(['rows' => '1','placeholder'=>'标题','class'=>'sll', 'id'=>'topic_title','maxlength'=>120])->label(false); ?>
<?=$form->field($content, 'content')->textArea(['id'=>'editor','class'=>'mll','placeholder'=>'正文' ,'autofocus'=>'autofocus', 'maxlength'=>30000])->label(false); ?>
<div class="sep5"></div>
<?=$form->field($model, 'node_id')->dropDownList(array(''=>'')+Node::getNodeList(), ['class'=>'nodes-select2','style'=>'width: 100%;  font-size: 12px; display: none;'])->label(false); ?></div>
<div class="cell">最热节点 <?php $hotNodes = Node::getHotNodes();foreach($hotNodes as $hn) {echo Html::a(Html::encode($hn['name']), 'javascript:chooseNode("'.$hn['id'].'");', ['class'=>'node']).' ';}?></div>
<div class="cell"><?=$form->field($model, 'access_auth')->dropDownList(Topic::$access, ['class'=>'access_auth','style'=>'width: 300px; font-size: 14px; display: none;'])->label(false); ?></div>
<div class="cell"><div class="fr fade">最多4个标签，以空格分隔</div>标签</div>
<?=$form->field($model, 'tags')->textInput(['id'=>'tags', 'maxlength'=>60])->label(false); ?>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton('发布主题', ['class' => 'super normal button']); ?>
<?php if( Yii::$app->getUser()->getIdentity()->canUpload($settings) ) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">图片上传</div>';}?>
</div>
<?php ActiveForm::end(); ?>
</div>

<?=$this->render('@app/views/common/tips'); ?></div>
<script>
autosize(document.querySelectorAll('textarea'));
</script>