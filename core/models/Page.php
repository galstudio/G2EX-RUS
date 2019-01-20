<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;

class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name','ename'], 'required'],
			['sortid', 'default', 'value' => 99],
            ['sortid', 'integer', 'min'=>0, 'max' => 99],
            ['name', 'string', 'max' => 20],
            ['ename', 'string', 'max' => 20],
            ['url', 'string', 'max' => 200],
			['url', 'url', 'defaultScheme' => 'http'],
            [['content'], 'string', 'max' => 20000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sortid' => '排序',
            'name' => '单页名',
            'ename' => '单页英文名',
            'url' => '跳转网址',
            'content' => '内容',
        ];
    }

	public static function getSingle()
	{
		$key = 'single';
		$cache = Yii::$app->getCache();
		$settings = Yii::$app->params['settings'];

		if ( intval($settings['cache_enabled']) === 0 || ($models = $cache->get($key)) === false ) {
		    $models = static::find()
				->orderBy(['sortid'=>SORT_ASC, 'id'=>SORT_ASC])
				->asArray()
		        ->all();
			if ( intval($settings['cache_enabled']) !== 0 ) {
				if ($models === null) {
					$models = [];
				}
				$cache->set($key, $models, intval($settings['cache_time'])*60);
			}
		}
		return $models;
	}

}
