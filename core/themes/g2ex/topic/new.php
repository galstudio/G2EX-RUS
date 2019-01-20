<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
use app\models\Node;
use app\models\Topic;
$session = Yii::$app->getSession();
$settings = Yii::$app->params['settings'];
$this->registerAssetBundle('app\assets\Select2Asset');
$this->registerJs('$(".nodes-select2").select2({placeholder:"Выберите тему",allowClear: true});');
$this->registerJs('$(".access_auth").select2({});');
\app\themes\g2ex\layouts\autosizeAsset::register($this);
$editorClass = '\app\plugins\SmdEditor\SmdEditor';
$editor = new $editorClass();
$editor->registerAsset($this);
$editor->registerTagItAsset($this);
\app\themes\g2ex\layouts\emojiAsset::register($this);
$title = 'Создание нового топика';
$this->title =Html::encode($settings['site_name']).' › '.$title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/tips'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box" id="new">
<div class="cell">
<div class="fr">
<a href="/new" class="super normal button">Markdown</a>&nbsp;&nbsp;<a href="/post" class="super normal button">UBB</a>
</div>
<?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=$title; ?>
</div>
<?php if ( $session->hasFlash('postNG') ) {?>
<div class="problem" onclick="$(this).slideUp('fast');"><?=$session->getFlash('postNG');?></div>
<?php }?>
<?php $form = ActiveForm::begin(); ?>
<?=$form->field($model, 'editor')->hiddenInput(['value'=>'SmdEditor'])->label(false);?>
<div class="cell"><div class="fr fade" id="title_remaining">120</div>Заголовок</div>
<div class="cell" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'title')->textArea(['rows' => '1','placeholder'=>'Введите заголовок топика,  если он может отразить полное содержание, то текст может быть пустым…','class'=>'msl', 'id'=>'topic_title','maxlength'=>120])->label(false); ?>
</div>
<div class="cell"><div class="fr fade" id="content_remaining">20000</div>Текст топика <span class="emotion">&nbsp;</span></div>
<div class="mc">
<?=$form->field($content, 'content')->textArea(['id'=>'editor','class'=>'msl', 'maxlength'=>30000])->label(false); ?></div>
<div class="cell"> <?=$form->field($model, 'node_id')->dropDownList(array(''=>'')+Node::getNodeList(), ['class'=>'nodes-select2','style'=>'width: 300px; font-size: 14px; display: none;'])->label(false); ?></div>
<div class="cell">Популярные темы: <?php $hotNodes = Node::getHotNodes();foreach($hotNodes as $hn) {echo Html::a(Html::encode($hn['name']), 'javascript:chooseNode("'.$hn['id'].'");', ['class'=>'node']).' ';}?></div>
<div class="cell"><?=$form->field($model, 'access_auth')->dropDownList(Topic::$access, ['class'=>'access_auth','style'=>'width: 300px; font-size: 14px; display: none;'])->label(false); ?></div>
<div class="cell"><div class="fr fade">Максимум 4 тега, разделенных пробелами</div>Теги</div>
<?=$form->field($model, 'tags')->textInput(['id'=>'tags', 'maxlength'=>60])->label(false); ?>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton('Опубликовать', ['class' => 'super normal button']); ?><?php if( Yii::$app->getUser()->getIdentity()->canUpload($settings) ) {$editor->registerUploadAsset($this);echo '<div id="fileuploader">&nbsp;</div>';}?>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
<script>
autosize(document.querySelectorAll('textarea'));
</script>
