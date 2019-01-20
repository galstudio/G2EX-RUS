<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\models\User;
use app\models\UserInfo;
use app\models\Notice;
use app\models\Topic;
use app\models\Token;
use app\models\History;
use app\models\Favorite;
use app\components\Util;

class MyController extends AppController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionNotifications()
    {
        $me = Yii::$app->getUser()->getIdentity();
//        $myId = Yii::$app->getUser()->id;
        $sysCount = $me->getSystemNoticeCount();

        $condition = ['<>', 'type', Notice::TYPE_MSG];
        $with = ['source', 'topic'];
        Notice::updateAll([
            'updated_at'=>time(),
            'status'=> 1,
        ], ['and', ['status'=> 0, 'target_id'=>$me->id], ['<>', 'type', Notice::TYPE_MSG]]);

        $query = Notice::find()->where(['target_id'=>$me->id])->andWhere($condition);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
        $notices = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
            ->with($with)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('notifications', [
             'notices' => $notices,
             'pages' => $pages,
             'sysCount'=>$sysCount,
        ]);
    }
    public function actionSms()
    {
        $me = Yii::$app->getUser()->getIdentity();
//        $myId = Yii::$app->getUser()->id;
        $smsCount = $me->getSmsCount();
        $condition = ['type'=> Notice::TYPE_MSG];
        $with = ['source'];
        Notice::updateAll([
            'updated_at'=>time(),
            'status'=> 1,
        ], ['status'=> 0, 'target_id'=>$me->id, 'type'=>Notice::TYPE_MSG]);

        $query = Notice::find()->where(['target_id'=>$me->id])->andWhere($condition);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
        $sms = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
            ->with($with)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('sms', [
             'sms' => $sms,
             'pages' => $pages,
             'smsCount'=>$smsCount,
        ]);
    }

    public function actionSettings()
    {
        return $this->render('settings');
    }
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
    public function actionAvatars()
    {
        return $this->render('avatar');
    }
    public function actionEmail()
    {
        return $this->render('email');
    }
    public function actionPassword()
    {
        return $this->render('password');
    }
    public function actionBalance()
    {
        $myId = Yii::$app->getUser()->id;
        if ( Yii::$app->getRequest()->getIsPost() ) {
            if( Yii::$app->getUser()->getIdentity()->reg == 0 && Yii::$app->getUser()->getIdentity()->userInfo->topic_count > 0){
            Yii::$app->getUser()->getIdentity()->mission();
            Yii::$app->getSession()->setFlash('RegOK', 'Вы успешно получили начальный капитал');
            }else{
             Yii::$app->getSession()->setFlash('RegNG', 'Сначала опубликуйте топик, потом вернитесь и завершите задачу');
            }
        }

        $query = History::find()->where(['type'=>History::TYPE_POINT, 'user_id'=>$myId]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
        $records = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('balance', [
             'records' => $records,
             'pages' => $pages,
        ]);

    }
    public function actionAdd()
    {
        $myId = Yii::$app->getUser()->id;
        $query = History::find()->where(['type'=>History::TYPE_POINT, 'user_id'=>$myId]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
        $records = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('add', [
             'records' => $records,
             'pages' => $pages,
        ]);
    }
    public function actionInviteCodes()
    {
        $myId = Yii::$app->getUser()->id;

        $query = Token::find()->where(['type'=>Token::TYPE_INVITE_CODE, 'user_id'=>$myId]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
        $records = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('inviteCodes', [
             'records' => $records,
             'pages' => $pages,
        ]);

    }

    public function actionNodes()
    {
        $me = Yii::$app->getUser()->getIdentity();

        $query = Favorite::find()->where(['type'=>Favorite::TYPE_NODE, 'source_id'=>$me->id]);
//      $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $me->userInfo->favorite_node_count, 'pageSize' => $this->settings['list_pagesize'], 'pageParam'=>'p']);
        $nodes = $query->orderBy(['id'=>SORT_DESC])->offset($pages->offset)
                ->innerJoinWith(['node'])
                ->limit($pages->limit)
                ->asArray()
                ->all();

        return $this->render('nodes', [
            'nodes' => $nodes,
            'pages' => $pages,
        ]);
    }

    public function actionTopics()
    {
        $me = Yii::$app->getUser()->getIdentity();

        $query = Favorite::find()->where(['type'=>Favorite::TYPE_TOPIC, 'source_id'=>$me->id]);
//      $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $me->userInfo->favorite_topic_count, 'pageSize' => $this->settings['list_pagesize'], 'pageParam'=>'p']);
        $topics = $query->orderBy(['alltop'=>SORT_DESC,'id'=>SORT_DESC])->offset($pages->offset)
                ->innerJoinWith(['topic'])
                ->with(['topic.author','topic.lastReply','topic.node'])
                ->limit($pages->limit)
                ->asArray()
                ->all();

        return $this->render('topics', [
            'topics' => $topics,
            'pages' => $pages,
        ]);
    }

    public function actionFollowing()
    {
        $query = Topic::find()->innerJoinWith('authorFollowedBy')->where([Favorite::tableName().'.source_id'=> Yii::$app->getUser()->id, Favorite::tableName().'.type'=>Favorite::TYPE_USER]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(1), 'pageSize' => $this->settings['list_pagesize'], 'pageParam'=>'p']);
        $topics = $query->select([Topic::tableName().'.id'])->orderBy([Topic::tableName().'.alltop'=>SORT_DESC,Topic::tableName().'.id'=>SORT_DESC])->offset($pages->offset)
                ->with(['topic.author','topic.node','topic.lastReply'])
                ->limit($pages->limit)
//              ->asArray()
                ->all();
        return $this->render('following', [
            'topics' => Util::convertModelToArray($topics),
            'pages' => $pages,
        ]);
    }

}
