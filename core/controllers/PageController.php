<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers;
use Yii;
use yii\web\NotFoundHttpException;
use app\models\Page;

class PageController extends AppController
{

    public function actionIndex($name)
    {
        $page = $this->findModel($name);
        return $this->render('index', [
            'page' => $page,
       ]);
    }
      protected function findModel($name, $with=null)
    {
        $model = Page::find()->select(['id', 'name', 'ename','content'])->where(['ename' => $name]);
        if ( !empty($with) ) {
            $model = $model->with($with);
        }
        $model = $model->asArray()->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('未找到['.$name.']单页');
        }
    }
}
