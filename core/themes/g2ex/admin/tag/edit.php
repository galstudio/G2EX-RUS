<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$title ='Редактирование тега';
$settings = Yii::$app->params['settings'];
$this->title = Html::encode($settings['site_name']) .' › '. $title;
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('Теги', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $title;?></div>
<div class="inner form">
<?php $form = ActiveForm::begin();
echo $form->field($model, 'name')->textInput(['maxlength' => 20,'class'=>'sl']);
?>
<div class="form-group">
            <label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('Изменить', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end();?>
<div class="sep10"></div>
</div>
</div>
</div>
