<?php

/**
 * main.php
 *
 * This file holds the configuration settings of your backend application.
 */
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../../common');
Yii::setPathOfAlias('public', __DIR__ . '/../../..');

$server_name =  $_SERVER['SERVER_NAME'];
$file_cf = "/$server_name/config.cf";
//if ((CfgFile::isSetFile($file_cf))) {
//    $GLOBALS['__data_configs'] = json_decode(CfgFile::readFile($file_cf), true);
//} else {
//    $GLOBALS['__data_configs'] = json_decode(file_get_contents(__DIR__ . '/config.cf'), true);
//}
$GLOBALS['__data_configs']['server_name'] = $server_name;
//config language
$lang = $GLOBALS['__data_configs']['language_backend'] ?  $GLOBALS['__data_configs']['language_backend'] : 'vi';
if (isset($_COOKIE['__language_backend'])) {
    $lang = $_COOKIE['__language_backend'];
} else {
    setcookie('__language_backend', $lang, strtotime('+365 days'), "/");
}
$GLOBALS['__data_configs']['language_backend'] = $lang;
return CMap::mergeArray(
    require(__DIR__ . '/../../../common/config/main.php'),
    array(
        'name' => $server_name,
        'id' => 'A',
        'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
        // preload components required before running applications
        'preload' => array('log'),
        'language' => $lang,
        'import' => array(
            'application.components.*',
            'application.controllers.*',
            'application.models.*',
            'application.classs.*',
            'application.widgets.*'
        ),
        'modules' => array(
            'app',
            'login',
            'media',
            'users',
            'affilliate',
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => 'abc',
                // If removed, Gii defaults to localhost only.
                'ipFilters' => array('127.0.0.1', '::1'),
            ),
        ),
        'components' => array(
            'user' => array(
                'allowAutoLogin' => true,
            ),
            'customer' => array(
                'class' => 'WebCustomer',
                'allowAutoLogin' => false,
            ),
            // 'errorHandler' => array(
            //     'errorAction' => 'site/site/error'
            // ),
            'errorHandler' => array(
                'errorAction' => 'site/error'
            ),
            'urlManager' => array(
                'class' => 'BUrlManager',
            ),
        ),
    ),
    (file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()),
    (file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
