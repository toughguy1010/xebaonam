<?php

/**
 * main.php
 *
 * This file holds the configuration settings of your backend application.
 */
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../../common');
Yii::setPathOfAlias('public', __DIR__ . '/../../..');

return CMap::mergeArray(
                require(__DIR__ . '/../../../common/config/main.php'), array(
            'name' => 'Web3Nhat BackOffice',
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            // preload components required before running applications
            'preload' => array('log'),
            'language' => 'vi',
            'import' => array(
                'application.components.*',
                'application.controllers.*',
                'application.models.*',
                'application.classs.*',
                'application.widgets.*'
            ),
            'modules' => array(
                'login',
                'setting',
                'content',
                'banner',
                'media',
                'installment',
                'widget',
                'manager',
                'interface',
                'economy',
                'useradmin',
                'custom',
                'work',
                'suggest',
                'sms',
                'car',
                'tour',
                'payment',
                'bds',
                'service',
                'hospital',
                'airline',
                'affiliate',
                'domain',
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
                /* load bootstrap components */
//                'bootstrap' => array(
//                    'class' => 'common.extensions.bootstrap.components.Bootstrap',
//                    'responsiveCss' => true,
//                ),
                'errorHandler' => array(
                    'errorAction' => 'site/error'
                ),
                'urlManager' => array(
                    'class' => 'BUrlManager',
                ),
            // 'urlManager' => array(
            // 'rules' => array(
            // 'tin-tuc' => array('news/news', 'urlSuffix' => '', 'caseSensitive' => false),
            // 'tin-tuc-i' => array('news/news/index', 'urlSuffix' => '', 'caseSensitive' => false),
            // 'form/thong-ke' => array('interface/customform/statistic', 'urlSuffix' => '', 'caseSensitive' => false),
            // '<controller:\w+>/<id:\d+>' => '<controller>/view',
            // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            // '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            // )
            // ),
            ),
                ), (file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()), (file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
