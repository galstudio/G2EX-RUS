<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\controllers;

class TopController extends AppController
{

    public function actionIndex()
    {
	    return $this->render('index');
    }
    public function actionRich()
    {
	    return $this->render('rich');
    }
}
