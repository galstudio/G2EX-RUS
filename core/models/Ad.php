<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\models\Node;

class Ad extends \yii\db\ActiveRecord
{
	const LOCATIONS = '{"0":"справа","1":"внизу", "2":"перед содержанием", "3":"после содержания", "4":"над списком"}';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
              [['location', 'name', 'content','expires'], 'required'],
              [['location', 'node_id', 'sortid'], 'integer'],
		 ['location', 'default', 'value' => 0],
              ['node_id', 'default', 'value' => 1],
              ['invisible', 'boolean'],
		 ['sortid', 'default', 'value' => 50],
              ['expires', 'date', 'format' => 'php:U-m-d'],
              ['name', 'string', 'max' => 20],
              ['content', 'string', 'max' => 5000],
        ];
    }
public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sortid' => 'Порядок',
            'location' => 'Расположение',
            'invisible' => 'Скрыть?',
            'node_id' => 'Тема',
            'expires' => 'Окончание',
            'name' => 'Название',
            'content' => 'Содержание',
        ];
    }
    public function getNode()
    {
        return $this->hasOne(Node::className(), ['id' => 'node_id']);
    }

          public static function getAds()
    {
      $key = 'ads';
      $cache = Yii::$app->getCache();
      $settings = Yii::$app->params['settings'];

      if ( intval($settings['cache_enabled']) === 0 || ($ads = $cache->get($key)) === false ) {
          $ads = static::find()
          ->where(['invisible' => 0])
          ->orderBy(['sortid'=>SORT_ASC, 'id'=>SORT_ASC])
          ->asArray()
              ->all();
        if ( intval($settings['cache_enabled']) !== 0 ) {
          if ($ads === null) {
            $ads = [];
          }
          $cache->set($key, $ads, intval($settings['cache_time'])*60);
        }
      }
      return $ads;
    }
  }
