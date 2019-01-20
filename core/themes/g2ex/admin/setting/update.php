<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
\app\assets\Select2Asset::register($this);
$this->registerJs("$('select').select2();");
$this->title = 'Настройки';
$blocks = [
    'info'=>['title'=>'Общие', 'msg'=>'', 'parts'=>null],
    'manage'=>['title'=>'Разное', 'msg'=>'', 'parts'=>null],
    'mailer'=>['title'=>'SMTP', 'msg'=>'После сохранения изменений, '. Html::a('отправьте тестовый email', ['admin/setting/test-email']), 'parts'=>null],
    'cache'=>['title'=>'Кэш', 'msg'=>'', 'parts'=>null],
    'upload'=>['title'=>'Загрузки', 'msg'=>'', 'parts'=>null],
    'extend'=>['title'=>'Код', 'msg'=>'', 'parts'=>null],
    'other'=>['title'=>'Другое', 'msg'=>'В целом можно оставить по умолчанию', 'parts'=>null],
];

function showSettingForm($settings, $form)
{
    ArrayHelper::multisort($settings, ['sortid', 'id'], [SORT_ASC, SORT_ASC]);
    foreach ($settings as $setting):
        if ($setting->type === 'select') {
            if ($setting->key === 'timezone') {
                $options = \DateTimeZone::listIdentifiers();
                $options = array_combine($options,$options);
            } else {
                $options = json_decode($setting->option,true);
            }
            echo $form->field($setting, "[$setting->id]value", ['enableError'=>false,])
                    ->dropDownList($options)->label($setting->label)->hint($setting->description);
        } else if ($setting->type === 'textarea') {
            echo $form->field($setting, "[$setting->id]value", ['enableError'=>false,])
                    ->textArea()->label($setting->label)->hint($setting->description);
        } else  {
            echo $form->field($setting, "[$setting->id]value", ['enableError'=>false,])->input($setting->type, $setting->type==='password'?['autocomplete'=>'new-password']:[])
                    ->label($setting->label)->hint($setting->description);
        }
    endforeach;
}
?>
<?=$this->render('@app/views/common/login'); ?>
<?=$this->render('@app/views/common/side'); ?>
</div>
<div id="Main">
<div class="sep20"></div>
<div class="box">
<div class="header"><div class="fr" style="margin: -3px -8px 0px 0px">
<?php foreach ($blocks as $key=>$block):?><a href="#<?=$key;?>" class="nav"><?=$block['title'];?></a>
<?php endforeach; ?>
</div><?=Html::a('Админпанель', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $this->title;?></div>
</div>
<?php foreach ($blocks as $key=>$block):?>
<?php if ($key=='info'){
   echo '<div class="box" style="border-top-left-radius:0px;border-top-right-radius:0px;margin-top:-1px">';
}else{
echo '<div class="sep20" id="'.$key.'"></div><div class="box">
<div class="cell"><div class="fr"><a href="#Top"><small>↑ Вверх</small></a></div>'.$block['title'].'</div>';
};?>
<div class="cell">
<div class="form">
<?php $form = ActiveForm::begin(['id' => 'form-setting']); ?>
<?php
if ( !empty($settings[$key]) ) {
    showSettingForm($settings[$key], $form);
}
if ( $block['parts'] ) {
    foreach($block['parts'] as $partKey=>$part) {
        echo '<p class="login-three-home"><strong>'.$part.'</strong></p>';
        showSettingForm($settings[$key.'.'.$partKey], $form);
    }
}
?>
<div class="form-group">
<label class="control-label"> &nbsp;&nbsp;</label>
<?=Html::submitButton('Сохранить', ['class' => 'super normal button']); ?> &nbsp;&nbsp;
<?=$block['msg']; ?>
<div class="sep10"></div>
</div>
<?php
ActiveForm::end();
?>
</div>
</div></div>
<?php endforeach; ?>
</div>

