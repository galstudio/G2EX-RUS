<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2016 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Node extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%node}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             [['name', 'ename', 'about','icon','image','index','editor'], 'trim'],
            [['name', 'ename'], 'required'],
            ['ename', 'match', 'pattern' => '/^[a-z0-9\-]*$/i'],
            [['name', 'ename'], 'string', 'max' => 20],
            [['about'], 'string'],
            [['access_auth', 'invisible','index'], 'boolean'],
            ['name', 'unique'],
            ['ename', 'unique'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
            'name' => 'Имя темы',
            'ename' => 'Алиас',
            'image' => 'Фон',
            'icon' => 'Иконка',
            'topic_count' => 'Число топиков',
            'access_auth' => 'Просмотр после авторизации',
            'invisible' => 'Топики только в этой теме',
            'index' => 'Рекомендовать эту тему в ленте на главной странице',
            'about' => 'Резюме',
            'editor' => 'Редактор',
        ];
    }

    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['node_id' => 'id']);
    }

    public static function getNodesWithoutNavi()
    {
        $query = (new \yii\db\Query)->from(['nn' => NaviNode::tableName()])->select(['nn.id'])->innerJoin(['nv'=>Navi::tableName()], 'nv.type = '.Navi::TYPE_ALLNODES. ' and nv.id = nn.navi_id')->where('nn.node_id=nd.id');
        return static::find()->from(['nd' => static::tableName()])->where(['not exists', $query])->orderBy(['id'=>SORT_ASC])->asArray()->all();
    }

    public static function findByEname($ename)
    {
        return static::findOne(['ename' => $ename]);
    }

    public static function findByName($name)
    {
        return static::findOne(['name' => $name]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert === true) {
            Siteinfo::updateCounterInfo('addNode');
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        Siteinfo::updateCounterInfo('deleteNode');
        return parent::afterDelete();
    }

    public static function updateCounterInfo($action, $id)
    {
        $upd = [
            'addTopic' => ['topic_count'=>1],
            'deleteTopic' => ['topic_count'=>-1],
            'followNode' => ['favorite_count'=>1],
            'unfollowNode' => ['favorite_count'=>-1],
        ];

        if( !isset($upd[$action]) ) {
            return false;
        }
        return static::updateAllCounters($upd[$action], ['id'=>$id]);
    }

    public static function getHotNodes()
    {
        $key = 'hot-nodes';
        $cache = Yii::$app->getCache();
        $settings = Yii::$app->params['settings'];

        if ( intval($settings['cache_enabled']) === 0 || ($hotNodes = $cache->get($key)) === false ) {
            $hotNodes = static::find()->select(['id', 'name', 'ename'])
                ->orderBy(['topic_count'=>SORT_DESC, 'id'=>SORT_DESC])
                ->limit($settings['hot_node_num'])
                ->asArray()
                ->all();
            if ( intval($settings['cache_enabled']) !== 0 ) {
                $cache->set($key, $hotNodes, intval($settings['cache_time'])*60);
            }
        }
        return $hotNodes;
    }
public static function getNewNodes()
    {
        $key = 'new-nodes';
        $cache = Yii::$app->getCache();
        $settings = Yii::$app->params['settings'];

        if ( intval($settings['cache_enabled']) === 0 || ($newNodes = $cache->get($key)) === false ) {
            $newNodes = static::find()->select(['id', 'name', 'ename'])
                ->orderBy(['created_at'=>SORT_DESC, 'id'=>SORT_DESC])
                ->limit($settings['hot_node_num'])
                ->asArray()
                ->all();
            if ( intval($settings['cache_enabled']) !== 0 ) {
                $cache->set($key, $newNodes, intval($settings['cache_time'])*60);
            }
        }
        return $newNodes;
    }
    public static function getIndexNodes()
    {
        $key = 'index-nodes';
        $cache = Yii::$app->getCache();
        $settings = Yii::$app->params['settings'];

        if ( intval($settings['cache_enabled']) === 0 || ($indexNodes = $cache->get($key)) === false ) {
            $indexNodes = static::find()->select(['id', 'name', 'ename'])
                ->where(['index'=>'1'])
                ->orderBy(['id'=>SORT_DESC])
                ->limit($settings['hot_node_num'])
                ->asArray()
                ->all();
            if ( intval($settings['cache_enabled']) !== 0 ) {
                $cache->set($key, $indexNodes, intval($settings['cache_time'])*60);
            }
        }
        return $indexNodes;
    }
    public static function getAllNodes()
    {
        $key = 'all-nodes';
        $cache = Yii::$app->getCache();
        $settings = Yii::$app->params['settings'];

        if ( intval($settings['cache_enabled']) === 0 || ($nodes = $cache->get($key)) === false ) {
            $nodes = static::find()->select(['id', 'name', 'ename'])
                ->orderBy(['id'=>SORT_DESC])
                ->asArray()
                ->all();
            if ( intval($settings['cache_enabled']) !== 0 ) {
                $cache->set($key, $nodes, intval($settings['cache_time'])*60);
            }
        }
        return $nodes;
    }

    public static function getNodeList()
    {
        $nodes = static::find()->select(['id', 'name', 'ename'])->orderBy(['ename'=>SORT_ASC])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($nodes, 'id', function($item) {
            return $item['name']. ' / '.$item['ename']. ' ';
        });
    }

}
