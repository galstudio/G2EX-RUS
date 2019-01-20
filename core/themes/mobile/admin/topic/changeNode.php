<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('.select2').select2();");
$settings = Yii::$app->params['settings'];
$title = '转移节点';
$this->title =Html::encode($settings['site_name']).' › '.$title;
$request = Yii::$app->getRequest();
$me = Yii::$app->getUser()->getIdentity();
$indexUrl = ['topic/index'];
$nodeUrl = ['topic/node', 'name'=>$model['node']['ename']];
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box" id="new">
<div class="cell"><?=Html::a(Html::encode($settings['site_name']), ['/']); ?> <span class="chevron">&nbsp;›&nbsp;</span> <?=Html::a(Html::encode($model['node']['name']), $nodeUrl); ?> <span class="chevron">&nbsp;›&nbsp;</span><?=$title; ?></div>
<?php $form = ActiveForm::begin(); ?>
<div class="cell"><?=$form->field($model, 'node_id')->dropDownList(\app\models\Node::getNodeList(), ['class'=>'select2','style'=>'width: 200px; font-size: 12px; display: none;']);?></div>
<div class="cell move" style="padding: 0px; background-color: #fff;">
<?=$form->field($model, 'title')->textArea(['rows' => '1','class'=>'msl', 'maxlength'=>120, 'readonly'=>'readonly']); ?>
</div>
<div class="cell" style="overflow: hidden;"><?=Html::submitButton($model->isNewRecord ? '发布主题' : '编辑主题', ['class' => 'super normal button']); ?>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>