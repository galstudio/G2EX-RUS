<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2017 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers\admin;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use app\models\Page;

class PageController extends CommonController
{
    public function actionIndex()
    {
		$query = Page::find();
	    $countQuery = clone $query;
	    $pages = new Pagination(['totalCount' => $countQuery->count('id'),'pageParam' => 'p']);
	    $single = $query->select(['id', 'name','ename', 'url','sortid'])->orderBy(['sortid'=>SORT_ASC, 'id'=>SORT_DESC])
			->offset($pages->offset)
	        ->limit($pages->limit)
			->asArray()
	        ->all();

        return $this->render('index', [
            'single' => $single,
            'pages' => $pages,
        ]);
    }
    public function actionAdd()
    {
        $model = new Page();

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('add', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->delete();
        return $this->goBack();
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('未找到id为['.$id.']的单页');
        }
    }

}
