<?php

/**
 * main.php
 *
 * Common configuration file for backoffice and public applications
 */
require(dirname(__FILE__) . "/SiteGlobal.php");
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');

require(dirname(__FILE__) . "/const.php");
require(__DIR__ . '/../../facebook-sdk/src/Facebook/autoload.php');
require(__DIR__ . '/../../PayPal-PHP-SDK/autoload.php');
require(__DIR__ . '/../../nusoap/nusoap.php');
require(__DIR__ . '/../../Google/config.php');
require(__DIR__ . '/../../Google/Google_Client.php');
require(__DIR__ . '/../../Google/contrib/Google_Oauth2Service.php');
return array(
    'language' => 'vi',
    'import' => array(
        'common.components.*',
        'common.components.sms.*',
        'common.models.*',
        'common.models.libs.*',
        'common.models.news.*',
        'common.models.settings.*',
        'common.models.media.*',
        'common.models.widgets.*',
        'common.models.interface.*',
        'common.models.economy.*',
        'common.models.sms.*',
        'common.models.car.*',
        'common.models.tour.*',
        'common.models.bds.*',
        'common.models.hospital.*',
        'common.models.services.*',
        'common.models.airline.*',
        'common.models.affiliate.*',
        'common.classs.*',
        'common.widgets.*',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=150.95.104.94;dbname=xebaonam',
            'emulatePrepare' => true,
            'username' => 'user_xebaonam1',
            'password' => 'VNwzxeTm325Jxjvm4DQR',
            'charset' => 'utf8',
            'initSQLs' => array('set names utf8'),
//            'enableProfiling' => true,
            //'schemaCachingDuration' => YII_DEBUG ? 0 : 8640000, // 100 days
            //'enableParamLogging' => YII_DEBUG,
        ),
        'urlManager' => array(
            'class' => 'UrlManager',
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '',
        ),
//        'cache' => extension_loaded('apc') ?
//                array(
//            'class' => 'CApcCache',
//                ) :
//                array(
//            'class' => 'CDbCache',
//            'connectionID' => 'db',
//            'autoCreateCacheTable' => true,
//            'cacheTableName' => 'cache',
//                ),
        'cache' => array(
            'class' => 'ClaCache',
            //'useMemcached' => true,
            'keyPrefix' => 'w3n',
            'cachePath' => 'common.cache',
            //'servers' => array(
            //    array(
            //        'host' => 'localhost',
            //        'port' => 1168,
            //        'weight' => 80,
            //    ),
            //),
        ),
        'cachefile' => array(
            'class' => 'ClaCacheFile',
        ),
        'clientScript' => array(
            'class' => 'ClientScript',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//                array(// configuration for the toolbar of yiidebugbt
//                    'class' => 'XWebDebugRouter',
//                    'config' => 'alignRight, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
//                    'levels' => 'error, warning, trace, profile, info',
//                    'allowedIPs' => array('127.0.0.1', '::1', '192.168.4.[0-9]{3}', '192\.168\.[0-5]{1}\.[0-9]{3}'),
//                    'ignoremodule' => array('api,media'),
//                )
            ),
        ),
        'assetManager' => array(
            'class' => 'UAssetManager',
        ),
        'messages' => array('basePath' => Yiibase::getPathOfAlias('common.messages')),
        'mailer' => array(
            'class' => 'W3NPHPMailer',
            'Host' => 'smtp.gmail.com',
            'Username' => 'web@ippeducation.vn',
            'Password' => 'Prometheus',
            'Port' => 465,
            'SMTPSecure' => 'ssl',
        ),
        'smser' => array(
            'class' => 'SMSTwilio',
            'sid' => 'AC891ea509809da1bb9c00f41d3261047f',
            'token' => 'e13d4ce0a21caba43f4d4e5b0056b966',
            'from' => '+14088906866'
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);

