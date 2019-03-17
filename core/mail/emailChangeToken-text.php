<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\helpers\Url;

$settings = Yii::$app->params['settings'];
$url = Url::to(['site/verify-email', 'token'=>$token->token], true);

?>
<?php echo $settings['site_name']; ?>Привет, пользователь!<br />
<br />
Ты подал заявку на изменение email, нажми на ссылку ниже, чтобы подтвердить действие:<br />
<?php echo Html::a($url, $url); ?><br />
<br />
Спасибо за твой визит и желаю тебе успехов!<br />
<br />
С уважением,<br />
<?php echo $settings['site_name']; ?> команда сайта<br />
<?php echo Yii::$app->getRequest()->getHostInfo(); ?><br />
