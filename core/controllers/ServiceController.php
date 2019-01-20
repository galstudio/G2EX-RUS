<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\UserInfo;
use app\models\Token;
use app\models\UploadForm;
use app\models\ChangePasswordForm;
use app\models\ChangeEmailForm;
use app\models\Notice;
use app\models\Auth;
use app\models\History;
use app\models\BuyInviteCodeForm;
use app\models\SendMsgForm;
use app\models\Favorite;
//use app\lib\Util;

class ServiceController extends AppController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'avatar' => ['post'],
//                    'cover' => ['post'],
                    'upload' => ['post'],
                    'edit-profile' => ['post'],
                    'change-email' => ['post'],
                    'change-password' => ['post'],
                    'unfavorite' => ['post'],
                    'good' => ['post'],
                ],
            ],
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

    public function actionEditProfile()
    {
        $me = Yii::$app->getUser()->getIdentity();
        $userInfo = $me->userInfo;
        $userInfo->scenario = UserInfo::SCENARIO_EDIT;

        if ( $userInfo->load(Yii::$app->getRequest()->post()) && $userInfo->save() ) {
            Yii::$app->getSession()->setFlash('EditProfileOK', 'Настройки успешно были сохранены!');
        } else {
            Yii::$app->getSession()->setFlash('EditProfileNG', implode('<br />', $userInfo->getFirstErrors()));
        }

        return $this->redirect(['my/settings']);
    }
    public function actionEditPrivacy()
    {
        $me = Yii::$app->getUser()->getIdentity();
        $userInfo = $me->userInfo;
        $userInfo->scenario = UserInfo::SCENARIO_EDIT;

        if ( $userInfo->load(Yii::$app->getRequest()->post()) && $userInfo->save() ) {
            Yii::$app->getSession()->setFlash('EditPrivacyOK', 'Настройки конфиденциальности успешно сохранены!');
        } else {
            Yii::$app->getSession()->setFlash('EditPrivacyNG', implode('<br />', $userInfo->getFirstErrors()));
        }

        return $this->redirect(['my/privacy']);
    }
    public function actionChangeEmail()
    {
        $model = new ChangeEmailForm();
        $model->load(Yii::$app->getRequest()->post());
        $result = $model->apply();
        Yii::$app->getSession()->setFlash($result[0], $result[1]);

//      return $this->goBack();
        return $this->redirect(['my/email']);
    }

    public function actionUnbindAccount($source)
    {
        $model = Auth::find()->where(['source'=>$source, 'user_id'=>Yii::$app->getUser()->id])->limit(1)->one();
        $model->delete();
        return $this->redirect(['my/settings']);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        $model->load(Yii::$app->getRequest()->post());
        $result = $model->apply();
        Yii::$app->getSession()->setFlash($result[0], $result[1]);

//      return $this->goBack();
        return $this->redirect(['my/password']);
    }

    public function actionSendActivateMail()
    {
        if (Token::sendActivateMail(Yii::$app->getUser()->getIdentity())) {
            Yii::$app->getSession()->setFlash('activateMailOK', 'Почта успешно отправлено, в письме перейдите по ссылке активации.');
        } else {
            Yii::$app->getSession()->setFlash('activateMailNG', 'Не удалось отправить почту');
        }

//      return $this->goBack();
        return $this->redirect(['my/settings']);
    }

    public function actionAvatar()
    {
        $session = Yii::$app->getSession();
        $me = Yii::$app->getUser()->getIdentity();

        $model = new UploadForm(Yii::$container->get('avatarUploader'), ['scenario' => UploadForm::SCENARIO_AVATAR]);
        $model->file = UploadedFile::getInstance($model, 'file');

        $result = $model->uploadAvatar($me->id);
        if ( $result ) {
            $me->avatar = $result;
            $me->save(false);
            $session->setFlash('setAvatarOK', 'Автар успешно загружен!');
        } else {
            $session->setFlash('setAvatarNG', implode('<br />', $model->getFirstErrors()));
        }

        return $this->redirect(['my/avatars']);
    }

/*    public function actionCover()
    {
        $session = Yii::$app->getSession();
        $me = Yii::$app->getUser()->getIdentity();

        $model = new UploadForm(Yii::$container->get('avatarUploader'), ['scenario' => UploadForm::SCENARIO_AVATAR]);
        $model->file = UploadedFile::getInstance($model, 'file');

        $result = $model->uploadAvatar($me->id, 'coverSizes');
        if ( $result ) {
            $me->userInfo->cover = $result;
            $me->userInfo->save(false);
            $session->setFlash('setCoverOK', '用户卡背景图片上传成功，显示可能有延迟，请刷新。');
        } else {
            $session->setFlash('setCoverNG', implode('<br />', $model->getFirstErrors()));
        }

        return $this->redirect(['my/settings', '#'=>'cover']);
    }
*/
    public function actionUpload()
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        $me = Yii::$app->getUser()->getIdentity();

        if( !$me->canUpload($this->settings) ) {
            return ['jquery-upload-file-error'=> 'У вас нет прав на загрузку вложений.' ];
        }

        $model = new UploadForm(Yii::$container->get('fileUploader'), ['scenario' => UploadForm::SCENARIO_UPLOAD]);
        $model->files = UploadedFile::getInstances($model, 'files');

        $result = $model->upload($me->id);
        if ( $result ) {
            return $result;
        } else {
            return ['jquery-upload-file-error'=> implode('<br />', $model->getFirstErrors()) ];
        }

    }

    public function actionFavorite()
    {
        $types = [
            'node' => Favorite::TYPE_NODE,
            'topic' => Favorite::TYPE_TOPIC,
            'user' => Favorite::TYPE_USER,
            'vote_topic' => Favorite::TYPE_VOTE_TOPIC,
            'vote_comment' => Favorite::TYPE_VOTE_COMMENT,
        ];
        $req = Yii::$app->getRequest();
        if ($req->getIsAjax()) {
            $data = $req->post();
            if ( !isset($types[$data['type']]) ) {
                return ['result'=>0, 'msg'=>'Неверный параметр'];
            }

            Favorite::add([
                'type'=>$types[$data['type']],
                'source_id'=>Yii::$app->getUser()->id,
                'target_id'=>$data['id'],
            ]);
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return ['result'=>1];
        }

//        return $this->goBack();
    }

    public function actionUnfavorite()
    {
        $types = [
            'node' => Favorite::TYPE_NODE,
            'topic' => Favorite::TYPE_TOPIC,
            'user' => Favorite::TYPE_USER,
            'vote_topic' => Favorite::TYPE_VOTE_TOPIC,
            'vote_comment' => Favorite::TYPE_VOTE_COMMENT,
        ];
        $req = Yii::$app->getRequest();
        if ($req->getIsAjax()) {
            $data = $req->post();
            if ( !isset($types[$data['type']]) ) {
                return ['result'=>0, 'msg'=>'Неверный параметр'];
            }

            Favorite::cancel([
                'type'=>$types[$data['type']],
                'source_id'=>Yii::$app->getUser()->id,
                'target_id'=>$data['id'],
            ]);
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return ['result'=>1];
        }


//        return $this->goBack();
    }

    public function actionSignin()
    {
        if ( Yii::$app->getRequest()->getIsPost() ) {
            Yii::$app->getUser()->getIdentity()->signin();
             Yii::$app->getSession()->setFlash('SigninOK', 'Вы успешно получили ежедневный бонус для авторизацию');
        }
        return $this->render('signin');

    }

    public function actionBuyInviteCode()
    {
        $model = new BuyInviteCodeForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            $model->apply();
            return $this->redirect(['my/invite-codes']);
        }
        return $this->render('buyInviteCode', [
            'model' => $model,
        ]);

    }

    public function actionSms($id=0, $to='')
    {
        $me = Yii::$app->getUser()->getIdentity();
        if( !$me->checkActionCost('sendMsg') ) {
            return $this->render('@app/views/common/info', [
                'title' => 'У вас нет интеграции',
                'status' => 'problem',
                'msg' => 'Ваших очков недостаточно, вы не можете отправлять сообщения. Ежедневная посещаемость может добавить 10-50 баллов.',
            ]);
        }
        $model = new SendMsgForm();
        $id = intval($id);
        $sms = null;
        if( $id>0 ) {
            $sms = Notice::findOne($id);
            if ( !$sms ) {
                throw new NotFoundHttpException('Неверный параметр');
            } else {
                $model->username = $sms->source->username;
            }
        } else if (!empty($to)) {
            $model->username = $to;
        }
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ( $model->apply() ) {
                Yii::$app->getSession()->setFlash('SendMsgOK', 'Персональное сообщение успешно отправлено.');
                $model = new SendMsgForm();
            }
        }
        return $this->render('sms', [
            'model' => $model,
            'sms' => $sms,
        ]);

    }

    public function actionGood()
    {
        $req = Yii::$app->getRequest();
        if ($req->getIsAjax()) {
            $data = $req->post();
            $me = Yii::$app->getUser()->getIdentity();
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $me->good($data['type'], intval($data['id']), intval($data['thanks']));
        }
    }

}
