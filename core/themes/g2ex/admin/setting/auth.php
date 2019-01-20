<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
//\app\assets\Select2Asset::register($this);
//$this->registerJs("$('select').select2();");
$this->title = 'Авторизация через соцсети';

function showSettingForm($settings, $form, $parentKey='')
{
    $key = 0;
    foreach ($settings as $setting):
        echo $form->field($setting, $parentKey.'['.$key.']key', ['enableError'=>false,])->hiddenInput(['class'=>'sl auth-key'])->label(false);
        if ($setting->type === 'select') {
            $options = json_decode($setting->option,true);
            echo $form->field($setting, $parentKey.'['.$key.']value', ['enableError'=>false,])
                    ->dropDownList($options, ['class'=>'sl auth-value auth-'.$setting->key])->label($setting->label)->hint($setting->description);
        } else if ($setting->type === 'textarea') {
            echo $form->field($setting, $parentKey.'['.$key.']value', ['enableError'=>false,])
                    ->textArea(['class'=>'sl auth-value auth-'.$setting->key])->label($setting->label)->hint($setting->description);
        } else  {
            echo $form->field($setting, $parentKey.'['.$key.']value', ['enableError'=>false,])->input($setting->type, ['class'=>'sl auth-value auth-'.$setting->key])
                    ->label($setting->label)->hint($setting->description);
        }
        $key++;
    endforeach;
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $this->title;?></div>
<div class="cell form">
<?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form-setting', ]); ?>
<div class="auth-items">
<?php
showSettingForm([$settings['auth_enabled']], $form, '[0]');
unset($settings['auth_enabled']);
$key = 0;
foreach($settings as $type=>$part) {
    $key++;
    echo '<div id=auth_',$key,' class="auth-item cell"><strong><span class="auth-item-id">', $type===1?'Настройки '.$type:$type.'Настройки входа', '</span> <span class="auth-item-del">Удалить</span></strong><hr>';
    showSettingForm($part, $form, '['.$key.']');
    echo '</div>';
}
?>
        </div>
        <div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
            <?=Html::submitButton('Изменить', ['class' => 'super normal button']); ?> <?=Html::button('Добавить', ['class' => 'super normal button auth-item-add']); ?>
<div class="sep10"></div>
        </div>

<?php
ActiveForm::end();
?>
</div>
</div>
</div>
