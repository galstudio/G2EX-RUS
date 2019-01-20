<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class SfHtml
{
    public static function uGroup($score)
    {
        $groups = ArrayHelper::getValue(Yii::$app->params, 'settings.groups');
        if ($groups) {
            foreach($groups as $key => $group) {
                if($group[0]>$score) {
                    break;
                }
            }
            return $group[1];
        }
        return '';
    }
    public static function uGroupNext($score)
    {
        $groups = ArrayHelper::getValue(Yii::$app->params, 'settings.groups');
        if ($groups) {
            foreach($groups as $key => $group) {
                if($group[0]>$score) {
                    break;
                }
            }
            return ($group[0]);
        }
        return '';
    }
    public static function uGroupRank($score)
    {
        $groups = ArrayHelper::getValue(Yii::$app->params, 'settings.groups');
        if ($groups) {
            foreach($groups as $key => $group) {
                if($group[0]>$score) {
                    break;
                }
            }
            return 'static/level/'.($key+1).'.png';
        }
        return '';
    }

    public static function uScore($score) {
        $result = '';
        $levels = [];
        if ($score > 10000) {
            $levels['gold'] = floor($score / 10000);
            $score = $score % 10000;
        }
        if ($score > 100) {
            $levels['silver'] = floor($score / 100);
            $score = $score % 100;
        }
        if ($score >= 0) {
            $levels['bronze'] = $score;
        }
        foreach($levels as $key=>$amount) {
             $result .= $amount . ' <img src="/static/images/' . $key . '.png" align="absmiddle" border="0" style="padding-bottom: 2px;"> ';
        }
        return $result;
    }

    public static function uLink($text, $ajaxLoad=false, $options=[])
    {
        $text = Html::encode($text);
        $url = ['user/view', 'username'=>$text];
        if( $ajaxLoad ) {
            $options['data-poload'] = Url::to($url);
        }
        return Html::a($text, $url, $options);
    }

    public static function uImg($user, $size='normal', $options=[])
    {
        return Html::img('@web/'.str_replace('{size}', $size, $user['avatar']), ['class'=>ArrayHelper::getValue(Yii::$app->params, 'settings.avatar_style', 'img-circle'),'alt'=> Html::encode($user['username'])]+$options);
    }

    public static function uImgLink($user, $size='normal', $options=['class'=>'media-left item-avatar'], $ajaxLoad=false)
    {
        $url = ['user/view', 'username'=>Html::encode($user['username'])];
        if( $ajaxLoad ) {
            $options['data-poload'] = Url::to($url);
        }
        return Html::a(self::uimg($user, $size), $url, $options);
    }

    public static function faIcon($classes)
    {
        return '<i class="fa '.implode(' fa-', $classes).'" aria-hidden="true"></i>';
    }

    public static function afterAllPosts($view)
    {
        $hook = new SfHook();
        $hook->bindEvents(SfHook::EVENT_AFTER_ALL_POSTS);
        $event = new SfEvent(['render'=>$view]);
        $hook->trigger(SfHook::EVENT_AFTER_ALL_POSTS, $event);
        return;
    }

}
