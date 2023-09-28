<?php

/**
 * main.php
 *
 * This file holds the configuration settings of your fontend application.
 */
Yii::setPathOfAlias('root', __DIR__ . '/../..');
Yii::setPathOfAlias('common', __DIR__ . '/../../common');
return CMap::mergeArray(
                require(__DIR__ . '/../../common/config/main.php'), array(
            'name' => 'Web3Nhat public',
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'preload' => array('log'),
            'language' => 'vi',
            'import' => array(
                'application.components.*',
                'application.controllers.*',
                'application.models.*',
                'application.classs.*',
                'application.widgets.*',
                'application.helper.*',
            ),
            'modules' => array(
                'login',
                'news',
                'introduce',
                'page',
                'site',
                'widget',
                'economy',
                'search',
                'media',
                'suggest',
                'content',
                'work',
                'profile',
                'car',
                'tour',
                'payment',
                'installment',
                'bds',
				'service',
				'hospital',
				'airline',
                'affiliate',
				'domain',
            ),
            'components' => array(
                'user' => array(
                    'allowAutoLogin' => true,
                ),
                'customer' => array(
                    'class' => 'WebCustomer',
                    'allowAutoLogin' => false,
                ),
                'errorHandler' => array(
                    'errorAction' => 'site/site/error'
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
//                        array(// configuration for the toolbar of yiidebugbt
//                            'class' => 'common.extensions.yii-debug.YiiDebugToolbarRoute',
//                            'ipFilters' => array('127.0.0.1', '118.70.171.109', '1.54.211.68', '113.23.51.250'),
//                        )
                    ),
                ),
            ),
                ), (file_exists(__DIR__ . '/main-env.php') ? require(__DIR__ . '/main-env.php') : array()), (file_exists(__DIR__ . '/main-local.php') ? require(__DIR__ . '/main-local.php') : array())
);
