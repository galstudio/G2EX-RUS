<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers\admin;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use app\models\admin\UserForm;
use app\models\admin\ChargePointForm;
use app\models\User;

class UserController extends CommonController
{

    public function actionActivate($id)
    {
        $model = $this->findUserModel($id);
		$model->status = User::STATUS_ACTIVE;
		$model->save(false);
		return $this->goBack();
    }

    public function actionIndex($status=User::STATUS_ACTIVE)
    {
        $model = new UserForm(['scenario' => UserForm::SCENARIO_SEARCH]);

        if ($model->load(Yii::$app->getRequest()->post())) {
		$user = User::find()->select(['id','username','email','score','status','role'])->where(['username'=>$model->username])->asArray()->one();
	        return $this->render('search', [
	            'model' => $model,
	            'user' => $user,
	        ]);
        } else {
			$query = User::find()->where(['status'=>$status]);
		    $countQuery = clone $query;
		    $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
		    $users = $query->select(['id','username','email','score','status','role'])->orderBy(['id'=>SORT_DESC])
				->offset($pages->offset)
		        ->limit($pages->limit)
				->asArray()
		        ->all();
		    return $this->render('index', [
	            'model' => $model,
		         'users' => $users,
		         'pages' => $pages,
		    ]);
		}
    }
/*
    public function actionDelete($id)
    {
        $model = $this->findUserModel($id);
		$model->delete();

        return $this->redirect('index');

    }
*/
    public function actionInfo($id)
    {
        $model = new UserForm(['scenario' => UserForm::SCENARIO_EDIT]);
        if ($model->find($id) == null) {
            throw new NotFoundHttpException('Пользователь с индефикатором ['.$id.'] не найден.');
        }
        if ($model->load(Yii::$app->getRequest()->post()) && $model->edit()) {
			Yii::$app->getSession()->setFlash('adminProfileOK', 'Информация о пользователе успешно изменена!');
        }

        return $this->render('userinfo', [
	         'user' => $model,
        ]);

    }

    public function actionResetPassword($id)
    {
        $model = new UserForm(['scenario' => UserForm::SCENARIO_RESET_PWD]);
        if ($model->find($id) == null) {
            throw new NotFoundHttpException('Пользователь с индефикатором ['.$id.'] не найден.');
        }
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->getSession()->setFlash('adminPwdOK', 'Пароль пользователя успешно изменен!');
		} else {
			Yii::$app->getSession()->setFlash('adminPwdNG', implode('<br />', $model->getFirstErrors()));
		}
		return $this->goBack();
    }

    public function actionCharge($to='')
    {
        $model = new ChargePointForm();
        if (!empty($to)) {
            $model->username = $to;
        }
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ( $model->apply() ) {
                Yii::$app->getSession()->setFlash('ChargePointOK', 'Операция успешно выполнена!');
                $model = new ChargePointForm();
            }
        }
        return $this->render('charge', [
            'model' => $model,
        ]);

    }

    protected function findUserModel($id, $with=null)
    {
		if ($with === null) {
			$model = User::findOne($id);
		} else {
			$model = User::find()->with($with)->where(['id'=>$id])->one();
		}
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Пользователь с индефикатором ['.$id.'] не найден.');
        }
    }

}
