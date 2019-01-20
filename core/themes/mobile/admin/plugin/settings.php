<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
$this->title = '插件['.$plugin['pid'].']配置';
function showSettingForm($settings, $form)
{
    foreach ($settings as $key=>$setting) {
        if ($setting['type'] === 'select') {
            $options = json_decode($setting['option'],true);
            echo $form->field($setting, "[$key]value", ['enableError'=>false,])
                    ->dropDownList($options)->label($setting['label'])->hint($setting['description']);
        } else if ($setting['type'] === 'textarea') {
            echo $form->field($setting, "[$key]value", ['enableError'=>false,])
                    ->textArea()->label($setting['label'])->hint($setting['description']);
        } else if ($setting['type'] === 'checkboxList') {
//            $options = json_decode($setting['option'],true);
//			$setting['value'] = json_decode($setting['value'],true);
            echo $form->field($setting, "[$key]value", ['enableError'=>false,])
                    ->inline()->checkboxList($setting['option'])->label($setting['label'])->hint($setting['description']);
        } else  {
            echo $form->field($setting, "[$key]value", ['enableError'=>false,])->input($setting['type'])
                    ->label($setting['label'])->hint($setting['description']);
        }
    }
}
?>
<?=$this->render('@app/views/common/side'); ?>
<div class="sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', Html::a('插件管理', ['index']), '<span class="chevron">&nbsp;›&nbsp;</span>', $this->title;?></div>
<div class="inner form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?php
if ( !empty($settings) ) {
    showSettingForm($settings, $form);
}
?>
        <div class="form-group">
            <label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('确定', ['class' => 'super normal button']); ?>
        </div>
<?php ActiveForm::end();?>
<div class="sep10"></div>
</div>
</div>