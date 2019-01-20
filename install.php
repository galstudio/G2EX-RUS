<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

define('SF_DIR', 'core');
define('SF_PATH', __DIR__.'/' . SF_DIR);

header("Content-Type: text/html; charset=UTF-8");

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    echo 'Версия php должна быть php 5.4.0 или выше';
    exit;
}

if (file_exists(SF_PATH . '/runtime/install.lock')) {
    echo 'Система уже установлена. Вы уверены, что хотите переустановить её? Если да, то выполните следующие пункты:'."\n".'1. Выполните резервное копирование данных;'."\n".'2. Удалите файл ' . SF_DIR . '/runtime/install.lock;'."\n".'3. Повторно запустите программу установки.';
    exit;
}

if ( !is_writeable(SF_PATH . '/config') ) {
    echo 'Каталог' . SF_DIR . '/config не имеет прав на запись. Пожалуйста, установите правильные права.';
    exit;
}

if ( !is_writeable(__DIR__.'/assets') ) {
    echo 'Каталог assets не имеет прав на запись. Пожалуйста, установите правильные права.';
    exit;
}

if ( !is_writeable(SF_PATH . '/runtime') ) {
    echo 'Каталог' . SF_DIR . '/runtime не имеет прав на запись. Пожалуйста, установите правильные права.';
    exit;
}

if ( !is_writeable(__DIR__.'/avatar') ) {
    echo 'Каталог avatar не имеет прав на запись. Пожалуйста, установите правильные права.';
    exit;
}

if ( !is_writeable(__DIR__.'/upload') ) {
    echo 'Каталог upload не имеет прав на запись. Пожалуйста, установите правильные права.';
    exit;
}

if (!file_exists(SF_PATH . '/config/db.php')) {
    if (!copy(SF_PATH . '/config/db.php.default', SF_PATH . '/config/db.php')) {
        echo 'Ошибка переименования файла' . SF_DIR . '/config/db.php.default в db.php';
        exit;
    }
}

if (!file_exists(SF_PATH . '/config/params.php')) {
    if (!copy(SF_PATH . '/config/params.php.default', SF_PATH . '/config/params.php')) {
        echo 'Ошибка переименования файла' . SF_DIR . '/config/params.php.default в params.php';
        exit;
    }
}

if (!file_exists(SF_PATH . '/config/plugins.php')) {
    if (!copy(SF_PATH . '/config/plugins.php.default', SF_PATH . '/config/plugins.php')) {
        echo 'Ошибка переименования файла' . SF_DIR . '/config/plugins.php.default в plugins.php';
        exit;
    }
}

header("Location: install");

?>
