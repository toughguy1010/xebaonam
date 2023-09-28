<?php

$config = dirname(__FILE__) . '/protected/config/main.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
if (YII_DEBUG) {
    ini_set('display_errors', 'on');
    error_reporting(E_ERROR);
}
chdir(dirname(__FILE__) . '/..');
require_once('common/lib/Yii/yii.php');
require_once('common/components/WebApplication.php');
require_once('common/lib/global.php');
require_once('api/protected/components/PublicWebApplication.php');
$app = Yii::createApplication('PublicWebApplication', require($config));
$app->run();