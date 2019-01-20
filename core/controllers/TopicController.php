<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\caching\DbDependency;
use app\models\User;
use app\models\Topic;
use app\models\TopicContent;
use app\models\Comment;
use app\models\Node;
use app\models\Navi;
use app\models\Tag;
use app\models\History;
use app\models\Favorite;
use app\components\Util;

class TopicController extends AppController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['new', 'add','post', 'edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $me = Yii::$app->getUser();
                            return ( !$me->getIsGuest() && ($me->getIdentity()->isActive() || $me->getIdentity()->isAdmin()) );
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    $me = Yii::$app->getUser();
                    if( !$me->getIsGuest() && $me->getIdentity()->isInactive() ) {
                        throw new ForbiddenHttpException('Учетная запись пока не активирована');
                    } else {
                        throw new ForbiddenHttpException('У вас не достаточно прав для выполнения этой операции.');
                    }
                },
            ],
        ];
    }

 public function actionIndex()
    {
        $pages = new Pagination([
            'totalCount' => Topic::find()->innerJoinWith('node', false)->where([Node::tableName().'.invisible'=>0])->count(Topic::tableName().'.id'),
            'pageSize' => intval($this->settings['index_pagesize']),
            'pageParam' => 'p',
        ]);
        return $this->render('home', [
             'topics' => Topic::getTopicsFromIndex($pages),
             'pages' => $pages,
        ]);
    }
    public function actionHome()
    {
        $pages = new Pagination([
            'totalCount' => Topic::find()->innerJoinWith('node', false)->where([Node::tableName().'.invisible'=>0])->count(Topic::tableName().'.id'),
            'pageSize' => intval($this->settings['index_pagesize']),
            'pageParam' => 'p',
        ]);
        return $this->render('home', [
             'topics' => Topic::getTopicsFromIndex($pages),
             'pages' => $pages,
        ]);
    }
    public function actionRecent()
    {
        $pages = new Pagination([
            'totalCount' => Topic::find()->innerJoinWith('node', false)->where([Node::tableName().'.invisible'=>0])->count(Topic::tableName().'.id'),
            'pageSize' => intval($this->settings['index_pagesize']),
            'pageParam' => 'p',
        ]);
        return $this->render('index', [
             'topics' => Topic::getTopicsFromIndex($pages),
             'pages' => $pages,
        ]);
    }

    public function actionNode($name)
    {
        $node = $this->findNodeModel($name);
        if (intval($node['access_auth']) === 1 && Yii::$app->getUser()->getIsGuest()) {
            Yii::$app->getSession()->setFlash('accessNG', '您查看的页面需要先登录');
            return $this->redirect(['site/login']);
        }
        $pages = new Pagination([
            'totalCount' => $node['topic_count'],
            'pageSize' => intval($this->settings['list_pagesize']),
            'pageParam' => 'p',
        ]);

        return $this->render('node', [
             'node' => $node,
             'topics' => Topic::getTopicsFromNode($node['id'], $pages),
             'pages' => $pages,
        ]);
    }

    public function actionNavi($name)
    {
        $navi = $this->findNaviModel($name, ['visibleNaviNodes.node']);
//      $navis = Navi::find()->where(['type'=>1])->orderBy(['sortid'=>SORT_ASC])->asArray()->all();
        return $this->render('navi', [
             'navi' => $navi,
//           'navis' => $navis,
             'topics' => Topic::getTopicsFromNavi($navi['id']),
        ]);
    }

    public function actionSearch($q)
    {
        $pages = new Pagination([
            'totalCount' => Topic::find()->where(['like', 'title', $q])->count('id'),
            'pageSize' => intval($this->settings['index_pagesize']),
            'pageParam' => 'p',
        ]);
        return $this->render('search', [
             'topics' => Topic::getTopicsFromSearch($pages, $q),
             'pages' => $pages,
             'title' => $q,
        ]);
    }

public function actionMembers()
    {
        $query = Topic::find()->innerJoinWith('authorFollowedBy')->where([Favorite::tableName().'.source_id'=> Yii::$app->getUser()->id, Favorite::tableName().'.type'=>Favorite::TYPE_USER]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(1), 'pageSize' => $this->settings['list_pagesize'], 'pageParam'=>'p']);
        $topics = $query->select([Topic::tableName().'.id'])->orderBy([Topic::tableName().'.alltop'=>SORT_DESC,Topic::tableName().'.id'=>SORT_DESC])->offset($pages->offset)
                ->with(['topic.author','topic.node','topic.lastReply'])
                ->limit($pages->limit)
//              ->asArray()
                ->all();
        return $this->render('members', [
            'topics' => Util::convertModelToArray($topics),
            'pages' => $pages,
        ]);
    }
    public function actionNodes()
    {
        $query = Topic::find()->innerJoinWith('nodeFollowedBy')->where([Favorite::tableName().'.source_id'=> Yii::$app->getUser()->id, Favorite::tableName().'.type'=>Favorite::TYPE_NODE]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(1), 'pageSize' => $this->settings['list_pagesize'], 'pageParam'=>'p']);
        $topics = $query->select([Topic::tableName().'.id'])->orderBy([Topic::tableName().'.alltop'=>SORT_DESC,Topic::tableName().'.id'=>SORT_DESC])->offset($pages->offset)
                ->with(['topic.author','topic.node','topic.lastReply'])
                ->limit($pages->limit)
//              ->asArray()
                ->all();
        return $this->render('nodes', [
            'topics' => Util::convertModelToArray($topics),
            'pages' => $pages,
        ]);
    }

    public function actionView($id)
    {
        $topic = Topic::getTopicFromView($id);
        if ( ( intval($topic['node']['access_auth']) === Topic::TOPIC_ACCESS_LOGIN ||
				intval($topic->access_auth) !== Topic::TOPIC_ACCESS_NONE
			 ) && Yii::$app->getUser()->getIsGuest()) {
            Yii::$app->getSession()->setFlash('accessNG', '您查看的页面需要先登录');
            return $this->redirect(['site/login']);
        }
        $pages = new Pagination([
            'totalCount' => $topic->comment_count,
            'pageSize' => intval($this->settings['comment_pagesize']),
            'pageParam' => 'p',
        ]);

        return $this->render('view', [
            'topic' => Util::convertModelToArray($topic),
            'comments' => Comment::getCommentsFromView($id, $pages),
            'pages' => $pages,
       ]);
    }
/*
    public function actionClick($id)
    {
        print_r(Topic::afterView($id));die;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'views' => Topic::afterView($id),
        ];
    }
*/
    public function actionAdd($node)
    {
        $request = Yii::$app->getRequest();
        $me = Yii::$app->getUser()->getIdentity();
        if( !$me->checkActionCost('addTopic') ) {
            return $this->render('@app/views/common/info', [
                'title' => '您的积分不足',
                'status' => 'problem',
                'msg' => '您的积分不足，不能发表主题贴。每日签到可以获取10-50不等积分。',
            ]);
        }

        $node = $this->findNodeModel($node);

        $topic = new Topic(['scenario' => Topic::SCENARIO_ADD, 'node_id' => $node['id'], 'user_id' => $me->id]);
        $content = new TopicContent();
        if ( $topic->load($request->post()) && $topic->validate() &&
            $content->load($request->post()) && $content->validate() ) {
            if( !$me->canPost(History::ACTION_ADD_TOPIC) ) {
                Yii::$app->getSession()->setFlash('postNG', '创建新主题太快，请稍后再创建。');
            } else {

    //          $topic->tags = Tag::getTags($topic->tags, $topic->title, $content->content);
                $topic->tags = Tag::getTags($topic->tags);
                $topic->save(false);
                $content->link('topic', $topic);
                return $this->redirect(['view', 'id' => $topic->id]);
            }
        }
        return $this->render('add', [
            'model' => $topic,
            'content' => $content,
            'node' => $node,
        ]);
    }

    public function actionNew()
    {
        $request = Yii::$app->getRequest();
        $me = Yii::$app->getUser()->getIdentity();
        if( !$me->checkActionCost('addTopic') ) {
            return $this->render('@app/views/common/info', [
                'title' => '您的积分不足',
                'status' => 'problem',
                'msg' => '您的积分不足，不能发表主题贴。每日签到可以获取10-50不等积分。',
            ]);
        }

        $topic = new Topic(['scenario' => Topic::SCENARIO_NEW, 'user_id' => $me->id]);
        $content = new TopicContent();

        if ( $topic->load($request->post()) && $topic->validate() &&
            $content->load($request->post()) && $content->validate() ) {
            if( !$me->canPost(History::ACTION_ADD_TOPIC) ) {
                Yii::$app->getSession()->setFlash('postNG', '创建新主题太快，请稍后再创建。');
            } else {

    //          $topic->tags = Tag::getTags($topic->tags, $topic->title, $content->content);
                $topic->tags = Tag::getTags($topic->tags);
                $topic->save(false);
                $content->link('topic', $topic);
                return $this->redirect(['view', 'id' => $topic->id]);
            }
        }
        return $this->render('new', [
            'model' => $topic,
            'content' => $content,
        ]);
    }

    public function actionPost()
    {
        $request = Yii::$app->getRequest();

        $topic = new Topic(['scenario' => Topic::SCENARIO_NEW, 'user_id' => Yii::$app->getUser()->id]);
        $content = new TopicContent();

        if ( $topic->load($request->post()) && $topic->validate() &&
            $content->load($request->post()) && $content->validate() ) {

//          $topic->tags = Tag::getTags($topic->tags, $topic->title, $content->content);
            $topic->tags = Tag::getTags($topic->tags);
            $topic->save(false);
            $content->link('topic', $topic);
            return $this->redirect(['view', 'id' => $topic->id]);
        }
        return $this->render('post', [
            'model' => $topic,
            'content' => $content,
        ]);
    }
    public function actionEdit($id)
    {
        $request = Yii::$app->getRequest();
        $me = Yii::$app->getUser()->getIdentity();

        $model = $this->findTopicModel($id, ['content','node']);
        if( !$me->canEdit($model) ) {
            throw new ForbiddenHttpException('您没有权限修改或已超过可修改时间。');
        }
        if( $me->isAdmin() ) {
            $model->scenario = Topic::SCENARIO_ADMIN_EDIT;
        } else {
            $model->scenario = Topic::SCENARIO_AUTHOR_EDIT;
        }
        if( !($content = $model->content) ) {
            $content = new TopicContent(['topic_id'=>$model->id]);
        }
        $oldTags = $model->tags;
        if ($model->load($request->post()) && $model->validate() &&
            $content->load($request->post()) && $content->validate() ) {
//          $model->tags = Tag::editTags($model->tags, $oldTags);
            $model->tags = Tag::getTags($model->tags);
            $model->save(false) && $content->save(false);
            Tag::afterTopicEdit($model->id, $model->tags, $oldTags);
            (new History([
                'user_id' => $me->id,
                'action' => History::ACTION_EDIT_TOPIC,
                'action_time' => $model->updated_at,
                'target' => $model->id,
                'ext' => '',
            ]))->save(false);

           return $this->redirect(Topic::getRedirectUrl($id, 0, $request->get('ip', 1), $request->get('np', 1)));
        }
        return $this->render('edit', [
            'model' => $model,
            'content' => $content,
        ]);
    }

    protected function findTopicModel($id, $with=null)
    {
        $model = Topic::find()->where(['id'=>$id]);
        if ( !empty($with) ) {
            $model = $model->with($with);
        }
        $model = $model->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('未找到id为['.$id.']的主题');
        }
    }

    protected function findNodeModel($name, $with=null)
    {
        $model = Node::find()->select(['id', 'name', 'ename', 'topic_count', 'favorite_count', 'access_auth','image','icon','about','editor'])->where(['ename' => $name]);
        if ( !empty($with) ) {
            $model = $model->with($with);
        }
        $model = $model->asArray()->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('未找到['.$name.']的节点');
        }
    }

    protected function findNaviModel($name, $with=null)
    {
        $model = Navi::find()->select(['id', 'name', 'ename'])->where(['ename' => $name, 'type'=>1]);
        if ( !empty($with) ) {
            $model = $model->with($with);
        }
        $model = $model->asArray()->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('未找到['.$name.']的导航');
        }
    }
}
