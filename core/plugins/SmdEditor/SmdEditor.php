<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\plugins\SmdEditor;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Setting;
use app\components\Editor;
use app\components\PluginInterface;

class SmdEditor extends Editor implements PluginInterface
{
    public static function info()
    {
        return [
            'id' => 'SmdEditor',
            'name' => 'Редактор Simple Markdown',
            'description' => 'Редактор Simple Markdown',
            'author' => 'SimpleForum',
            'url' => 'http://simpleforum.org',
            'version' => '1.0',
            'config' => [],
        ];
    }

    public static function install()
    {
        if ( ($setting = Setting::findOne(['key'=>'editor'])) ) {
            $option = json_decode($setting->option, true);
            $option['SmdEditor']='Редактор Simple Markdown';
            $setting->option = json_encode($option);
            $setting->save();
    }
        return true;
    }

    public static function uninstall()
    {
        if ( ($setting = Setting::findOne(['key'=>'editor'])) ) {
            $option = json_decode($setting->option, true);
            unset($option['SmdEditor']);
            $setting->option = json_encode($option);
            $setting->save();
    }
        return true;
    }

    public function registerAsset($view)
    {
        SmdAsset::register($view);
        $view->registerJs("var editor = new SimpleMarkdown({target: '#editor', lan:'ru'});");
    }

    public function parseEditor($text, $autoLink=false)
    {
        if ( empty($this->_parser) ) {
            $this->_parser = new SmdParser();
        }
        return $this->_parser->setUrlsLinked($autoLink)->setMarkupEscaped(true)->text($text);
    }

}
