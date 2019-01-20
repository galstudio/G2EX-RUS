<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\themes\g2ex\layouts;

use yii\web\AssetBundle;

class highlightAsset extends AssetBundle
{
//    public $basePath = '@webroot';
    public $baseUrl = '@web/static';
    public $css = [
        'css/monokai_sublime.min.css',
    ];
    public $js = [
        'js/highlight.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
