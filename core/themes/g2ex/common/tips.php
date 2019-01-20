<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */
use yii\helpers\Html;
$settings = Yii::$app->params['settings'];
?>
<div class="sep20"></div>
<div class="box">
    <div class="cell">Советы</div>
    <div class="inner">
        <ul style="margin-top: 0px;">
            <li><span class="f13">Название топика</span><div class="sep10"></div>
            Если можно описать содержание топика в заголовке, чтобы было ясно о чём речь, то нет необходимости не добавлять к нему текст.
            <div class="sep10"></div>
            </li>
            <li><div class="fr" style="margin-top: -5px; margin-right: 5px;"><img src="/static/images/markdown.png" border="0" width="32"></div><span class="f13">Текст</span><div class="sep10"></div>
            Если вы хотите добавить больше деталей в текст, то можете воспользоваться разметкой Markdown.
            <div class="sep10"></div>
            Для просмотра, вы можете нажать кнопку <i class="icon-preview icon-block" style="float:none"></i> в верхнем правом углу редактора, чтобы увидеть фактический текст рендеринга Markdown.
            <div class="sep10"></div>
            </li>
            <li><span class="f13">Выбор темы</span><div class="sep10"></div>
            Выберите тему для вашего топика. Правильный выбор сделает ваш пост более полезным.<div class="sep10"></div></li>
            <li><span class="f13">Заполните теги</span><div class="sep10"></div>
            Укажите теги для вашего топика. С помощью них пользователи смогут легче найти нужную информацию..
            <div class="sep10"></div>
            Вы можете добавить теги в течении <strong><?=Html::encode($settings['edit_space']); ?> минут</strong>, после того как топик был опубликован.
            </li>
        </ul>
    </div>
</div>
