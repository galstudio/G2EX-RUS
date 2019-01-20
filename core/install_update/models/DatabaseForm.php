<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

namespace app\install_update\models;

use Yii;
use yii\base\Model;
use app\components\Util;

/**
 * Database form
 */
class DatabaseForm extends Model
{
    public $host = 'localhost';
    public $port = 3306;
    public $dbname;
    public $username = 'root';
    public $password;
    public $tablePrefix = 'g2ex_';
    private $_dbConfig = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host', 'dbname', 'username', 'tablePrefix'], 'trim'],
            [['host', 'dbname', 'username'], 'required'],
            [['password'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'host' => 'Сервер',
            'port' => 'Порт',
            'dbname' => 'База данных',
            'username' => 'Логин БД',
            'password' => 'Пароль БД',
            'tablePrefix' => 'Префикс таблиц',
        ];
    }

    public function checkDbInfo()
    {
        $port = (empty($this->port)||$this->port=='3306'?'':';port='.$this->port);
        $this->_dbConfig = [
            'dsn' => 'mysql:host='.$this->host. $port . ';dbname='.$this->dbname,
            'username' => $this->username,
            'password' => $this->password,
            'tablePrefix' => $this->tablePrefix,
            'charset' => 'utf8',
        ];
        $db = new \yii\db\Connection($this->_dbConfig);
//      try {
            $db->open();
//      } catch (\yii\db\Exception $e) {
//          throw new \yii\base\InvalidParamException('数据库连接出错：'. $e->getMessage());
//      }
        return $db;
    }

    public function excuteSql($file)
    {
        $db = $this->checkDbInfo();
        $sql = file_get_contents($file);
        $sql = str_replace('g2ex_', $this->_dbConfig['tablePrefix'], $sql);
        $db->createCommand($sql)->execute();
    }

    public function createDbConfig() {
        $this->createConfigFile(Yii::getAlias('@app/config/db.php'), array_merge(['class'=>'yii\db\Connection', 'enableSchemaCache'=>true], $this->_dbConfig));
    }

    private function createConfigFile($file, $settings)
    {
        $config = '<?php'."\n";
        $config = $config. 'return ';
        $config = $config. Util::convertArrayToString($settings, '');
        $config = $config. ';'."\n";

        file_put_contents($file, $config);
    }

}
