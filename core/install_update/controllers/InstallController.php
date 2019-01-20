<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\install_update\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\ServerErrorHttpException;
use yii\web\ForbiddenHttpException;
use app\install_update\lib\RequirementChecker;
use app\install_update\models\DatabaseForm;
use app\install_update\models\AdminSignupForm;

class InstallController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return !file_exists(Yii::getAlias('@runtime/install.lock'));
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                        throw new ForbiddenHttpException('Система уже установлена. Вы уверены, что хотите переустановить её? Если да, то выполните следующие пункты:'."\n".'1. Выполните резервное копирование данных;'."\n".'2. Удалите файл runtime/install.lock;'."\n".'3. Повторно запустите программу установки.');
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (version_compare(PHP_VERSION, '4.3', '<')) {
            echo 'Версия php должна быть php 4.3 или выше';
            exist;
        }

        $requirementsChecker = new RequirementChecker();

        $gdMemo = $imagickMemo = 'Необходимо установить gd или включить imagick';
        $gdOK = $imagickOK = false;

        if (extension_loaded('imagick')) {
            $imagick = new \Imagick();
            $imagickFormats = $imagick->queryFormats('PNG');
            if (in_array('PNG', $imagickFormats)) {
                $imagickOK = true;
            } else {
                $imagickMemo = 'Imagick (поддержка формата png)';
            }
        }

        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
            if (!empty($gdInfo['FreeType Support'])) {
                $gdOK = true;
            } else {
                $gdMemo = 'gd не поддерживает FreeType';
            }
        }

        /**
         * Adjust requirements according to your application specifics.
         */
        $requirements = array(
            array(
                'name' => 'Версия PHP',
                'mandatory' => true,
                'condition' => version_compare(PHP_VERSION, '5.4.0', '>='),
                'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
                'memo' => 'PHP 5.4.0 и выше',
            ),
            array(
                'name' => 'core/config',
                'mandatory' => true,
                'condition' => is_writeable(Yii::getAlias('@app/config')),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'core/config (требуется права на запись)',
            ),
            array(
                'name' => 'core/runtime',
                'mandatory' => true,
                'condition' => is_writeable(Yii::getAlias('@app/runtime')),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'core/runtime (требуется права на запись)',
            ),
            array(
                'name' => 'assets',
                'mandatory' => true,
                'condition' => is_writeable(Yii::getAlias('@webroot/assets')),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'assets (требуется права на запись)',
            ),
            array(
                'name' => 'avatar',
                'mandatory' => true,
                'condition' => is_writeable(Yii::getAlias('@webroot/avatar')),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'avatar (требуется права на запись)',
            ),
            array(
                'name' => 'upload',
                'mandatory' => true,
                'condition' => is_writeable(Yii::getAlias('@webroot/upload')),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'upload (требуется права на запись)',
            ),
            // Database :
            array(
                'name' => 'PDO',
                'mandatory' => true,
                'condition' => extension_loaded('pdo'),
                'by' => 'DB соединение',
                'memo' => 'MySQL (подключение)',
            ),
            array(
                'name' => 'PDO_MySQL',
                'mandatory' => true,
                'condition' => extension_loaded('pdo_mysql'),
                'by' => 'DB соединение',
                'memo' => 'MySQL (подключение)',
            ),
            // openssl :
            array(
                'name' => 'OpenSSL',
                'mandatory' => true,
                'condition' => extension_loaded('openssl'),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => 'Шифрование паролей пользователей',
            ),
/*          // File Upload :
            array(
                'name' => 'FileInfo扩展',
                'mandatory' => true,
                'condition' => extension_loaded('fileinfo'),
                'by' => '<a href="http://simpleforum.org">Simple Forum</a>',
                'memo' => '用于文件上传',
            ),
*/
            // Cache :
            array(
                'name' => 'Memcache(d)',
                'mandatory' => false,
                'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
                'by' => 'memcache/memcached (кэш)',
                'memo' => 'Кэширование системы',
            ),
            array(
                'name' => 'APC',
                'mandatory' => false,
                'condition' => extension_loaded('apc'),
                'by' => 'APC (кэш)',
                'memo' => 'Кэширование системы',
            ),
            // CAPTCHA:
            array(
                'name' => 'GD (поддержка FreeType)',
                'mandatory' => false,
                'condition' => $gdOK,
                'by' => 'Проверочный код',
                'memo' => $gdMemo,
            ),
            array(
                'name' => 'ImageMagick (поддержка png)',
                'mandatory' => false,
                'condition' => $imagickOK,
                'by' => 'Проверочный код',
                'memo' => $imagickMemo,
            ),
            // PHP ini :
            'phpExposePhp' => array(
                'name' => 'php.ini значение expose_php',
                'mandatory' => false,
                'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
                'by' => 'безопасность',
                'memo' => 'Измените его на expose_php = Off',
            ),
            'phpAllowUrlInclude' => array(
                'name' => 'php.ini значение allow_url_include',
                'mandatory' => false,
                'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
                'by' => 'безопасность',
                'memo' => 'Измените его на allow_url_include = Off',
            ),
            'phpSmtp' => array(
                'name' => 'PHP SMTP',
                'mandatory' => false,
                'condition' => strlen(ini_get('SMTP'))>0,
                'by' => 'почта',
                'memo' => 'Для отправки почты',
            ),
            array(
                'name' => 'MBString',
                'mandatory' => true,
                'condition' => extension_loaded('mbstring'),
                'by' => '<a href="http://www.php.net/manual/en/book.mbstring.php">Multibyte string</a> processing',
                'memo' => ''
            ),
            array(
                'name' => 'Reflection',
                'mandatory' => true,
                'condition' => class_exists('Reflection', false),
                'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ),
            array(
                'name' => 'PCRE',
                'mandatory' => true,
                'condition' => extension_loaded('pcre'),
                'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ),
            array(
                'name' => 'SPL',
                'mandatory' => true,
                'condition' => extension_loaded('SPL'),
                'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
            ),
        );
        $requirementsChecker->check($requirements);
        return $this->render('index', ['check'=>$requirementsChecker]);
    }

    public function actionDbSetting()
    {
        $session = Yii::$app->getSession();
        if ( !$session->has('install-step') || $session->get('install-step') < 1 ) {
            return $this->redirect(['index']);
        }

        $model = new DatabaseForm();
        $error = false;
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            try {
                $model->excuteSql($this->module->basePath . '/data/g2ex.sql');
                $model->createDbConfig();
                $session->set('install-step', 2);
                return $this->redirect(['create-admin']);
            } catch (\yii\db\Exception $e) {
                $error = 'Ошибка подключения к базе данных, убедитесь, что информация о подключении к базе правильная:<br />' . $e->getMessage();
            }
        }
        return $this->render('dbSetting', ['model'=>$model, 'error'=>$error]);
    }

    public function actionCreateAdmin()
    {
        $session = Yii::$app->getSession();
        if ( !$session->has('install-step') || $session->get('install-step') < 1 ) {
            return $this->redirect(['index']);
        } else if ($session->get('install-step') == 1) {
            return $this->redirect(['db-setting']);
        } else if ($session->get('install-step') == 9) {
            return $this->render('completed');
        }

        $model = new AdminSignupForm();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $session->set('install-step', 9);
                    $this->createInstallLockFile();
                    return $this->render('completed');
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    private function createInstallLockFile()
    {
        return file_put_contents(Yii::getAlias('@runtime/install.lock'), '');
    }

}
