<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\helpers\Url;

$settings = Yii::$app->params['settings'];
$url = Url::to(['site/activate', 'token'=>$token->token], true);

?>
Привет, <?php echo $username; ?><br />
<br />
Вы успешно зарегистрировались на <?php echo $settings['site_name']; ?><br />
<br />
Пожалуйста, перейдите по ссылке ниже, чтобы активировать свою учетную запись:<br />
<?php echo Html::a($url, $url); ?><br />
<br />
Спасибо за ваш визит!<br />
<br />
С уважением,<br />
команда <?php echo $settings['site_name']; ?> <br />
<?php echo Yii::$app->getRequest()->getHostInfo(); ?><br />
