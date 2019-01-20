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
$this->title = '基本设置';
$blocks = [
    'info'=>['title'=>'基本', 'msg'=>'', 'parts'=>null],
    'manage'=>['title'=>'管理', 'msg'=>'', 'parts'=>null],
    'mailer'=>['title'=>'SMTP', 'msg'=>'修改保存后，请 '. Html::a('测试邮件发送', ['admin/setting/test-email']), 'parts'=>null],
    'cache'=>['title'=>'缓存', 'msg'=>'', 'parts'=>null],
    'upload'=>['title'=>'上传', 'msg'=>'', 'parts'=>null],
    'extend'=>['title'=>'扩展', 'msg'=>'', 'parts'=>null],
    'other'=>['title'=>'其它', 'msg'=>'下面一般保持默认', 'parts'=>null],
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
<?=$this->render('@app/views/common/side'); ?>

<div class="c sep5"></div>
<div class="box">
<div class="header"><?=Html::a('管理后台', ['admin/setting/']), '<span class="chevron">&nbsp;›&nbsp;</span>', $this->title;?>
<div style="margin:5px">
<?php foreach ($blocks as $key=>$block):?><a href="#<?=$key;?>" class="nav"><?=$block['title'];?></a>
<?php endforeach; ?>
</div>
</div>
</div>
<?php foreach ($blocks as $key=>$block):?>
<?php if ($key=='info'){
   echo '<div class="box" style="border-top-left-radius:0px;border-top-right-radius:0px;margin-top:-1px">';
}else{
echo '<div class="sep5"></div><div class="box">
<div class="cell"><div class="fr"><a href="#Top"><small>↑ 回到顶部</small></a></div>'.$block['title'].'</div>';
};?>
<div class="cell" id="<?=$key;?>">
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
<?=Html::submitButton('保存设置', ['class' => 'super normal button']); ?> &nbsp;&nbsp;
<?=$block['msg']; ?>
<div class="sep5"></div>
</div>
<?php
ActiveForm::end();
?>
</div>
</div></div>
<?php endforeach; ?>
</div>
</div>