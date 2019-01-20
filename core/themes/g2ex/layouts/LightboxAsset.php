<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\themes\g2ex\layouts;

use yii\web\AssetBundle;

class LightboxAsset extends AssetBundle
{
//    public $basePath = '@webroot';
    public $baseUrl = '@web/static';
    public $css = [
        'css/lightbox.min.css',
    ];
	public $js = [
        'js/lightbox.min.js?v=1',
    ];
}
