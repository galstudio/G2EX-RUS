<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\SfHtml;

$settings = Yii::$app->params['settings'];
$me = Yii::$app->getUser()->getIdentity();

//$editor = new \app\lib\Editor(['editor'=>$settings['editor']]);
$editorClass = '\app\plugins\\'. $settings['editor']. '\\'. ucfirst($settings['editor']);
$editor = new $editorClass();
$editor->registerAsset($this);

$this->title = 'Правка комментария';
?>

<div class="row">
<div class="col-md-8 sf-left">

<div class="panel panel-default sf-box">
	<div class="panel-body">
		<?php echo Html::a('Главная', ['topic/index']), '&nbsp;/&nbsp;', Html::a(Html::encode($topic['node']['name']), ['topic/node', 'name'=>$topic['node']['ename']]); ?>
		<h3><?php echo Html::encode($topic['title']); ?></h3>
		<small class="gray">
		<?php echo 'by ', SfHtml::uLink($topic['author']['username']),
			'  •  ', Yii::$app->getFormatter()->asRelativeTime($topic['created_at']); ?>
		</small>
	</div>
</div>

<div class="panel panel-default sf-box">
	<div class="panel-heading">Правка комментария</div>
	<div class="panel-body">
<?php $form = ActiveForm::begin(); ?>
<?php
	if($me->isAdmin()) {
	 	echo $form->field($comment, 'invisible')->dropDownList(['Публичный', 'Личный'])->label(false);
	}
	echo $form->field($comment, 'content')->textArea(['id'=>'editor', 'maxlength'=>30000])->label(false);
	if($me->canUpload($settings)) {
		$editor->registerUploadAsset($this);
		echo '<div class="form-group"><div id="fileuploader">Загрузка изображения</div></div>';
	}
?>
    <div class="form-group">
        <?php echo Html::submitButton('<i class="fa fa-pencil-square-o" title="Правка"></i>', ['class' => 'btn btn-primary']); ?>
    </div>

<?php ActiveForm::end(); ?>	</div>
</div>

</div>

<div class="col-md-4 sf-right">
<?php echo $this->render('@app/views/common/_right'); ?>
</div>

</div>
