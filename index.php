<?php
//phpinfo();die('1234');
//die('He thong tam thoi dung hoat dong de nang cap! Chung toi se hoat dong tro lai ngay. Xin loi vi su bat tien nay.');
//error_reporting(E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh');
ini_set("date.timezone", 'Asia/Ho_Chi_Minh');
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
$debug = false;
if (isset($_GET['debug'])) {
    $debug = true;
}
//$debug = true;
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', $debug);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 0);

if(YII_DEBUG){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}else{
    ini_set('display_errors', 0);
    error_reporting(0);
}

require_once('common/lib/Yii/yii.php');
require_once('common/components/WebApplication.php');
require_once('common/lib/global.php');
require_once('protected/components/PublicWebApplication.php');

$app = Yii::createApplication('PublicWebApplication', require($config));
$app->run();
