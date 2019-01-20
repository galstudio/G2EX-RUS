<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\plugins\KeywordFilter;

use Yii;
use app\components\SfHook;
use app\components\PluginInterface;

class KeywordFilter implements PluginInterface
{
    public static function info()
    {
        return [
            'id' => 'KeywordFilter',
            'name' => '关键字过滤',
            'description' => '违规词过滤',
            'author' => 'SimpleForum',
            'url' => 'http://simpleforum.org',
            'version' => '1.0',
            'config' => [
                [
                    'label'=>'过滤关键字',
                    'key'=>'keywords',
                    'type'=>'textarea',
                    'value_type'=>'text',
                    'value'=>'',
                    'description'=>'一行一个过滤词',
                ],
            ],
        ];
    }

    public static function install()
    {
        return true;
    }

    public static function uninstall()
    {
        return true;
    }

    public static function events()
    {
        return [
            SfHook::EVENT_AFTER_PARSE => 'keywordFilter'
        ];
    }

    public static function keywordFilter($event)
    {
        if ( !isset($event->output) || empty($event->output)) {
            return true;
        }
        $words = explode("\r\n", $event->data['keywords']);
        $words = array_filter($words);
        if (empty($words)) {
            return true;
        }
        $words = array_map(function($word) {return '/'.$word.'/';}, $words);

        $event->output = preg_replace($words, ' ### ', $event->output);
        return true;
    }

}
