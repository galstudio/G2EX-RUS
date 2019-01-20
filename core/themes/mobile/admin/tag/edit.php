<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$title ='编辑标签';
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('标签管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="inner form">
<?php $form = ActiveForm::begin();
echo $form->field($model, 'name')->textInput(['maxlength' => 20,'class'=>'sl']);
?>
<div class="form-group">
            <label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('确定', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end();?>
<div class="sep10"></div>
</div>
</div>