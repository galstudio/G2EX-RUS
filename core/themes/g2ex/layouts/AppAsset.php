<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2016 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\themes\g2ex\layouts;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot';
    public $baseUrl = '@web/static';
    public $css = [
        'css/icon/iconfont.css?v=20170330',
        'css/style.css?v=20170330',
        'css/desktop.css?v=20170330',
    ];
    public $js = [
        'assets/jquery-qrcode/jquery.qrcode.min.js',
        'js/jquery.lazyload.min.js',
        'js/simpleforum.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
