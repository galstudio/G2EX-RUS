<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\themes\g2ex\layouts;

use yii\web\AssetBundle;

class emojiAsset extends AssetBundle
{
//    public $basePath = '@webroot';
    public $baseUrl = '@web/static';
    public $js = [
         'js/emoji.js',
    ];
}
