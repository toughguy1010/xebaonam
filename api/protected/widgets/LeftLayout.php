<?php

/*
 * @Author: MinhBN
 * @email: minhbachngoc@orenj.com
 * @date: 12/30/2013
 * 
 * @description: to show the left of main layout
 */

class LeftLayout extends CWidget
{

    public $data;
    public $first = true;
    public $module;
    protected $view = 'layoutleft';
    protected $parent_id = 0;

    public function init()
    {
        $addition = array();
        if (Yii::app()->controller->user->isRoot()) {
            $addition += array(
                'affilliate' => array(
                    'menu_title' => Yii::t('affilliate', 'affilliate_config'),
                    'menu_link' => Yii::app()->createUrl('/affilliate/config/index'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-user',
                ),
            );
        } else {
            $addition += array(
                'affilliate' => array(
                    'menu_title' => Yii::t('affilliate', 'affilliate_static'),
                    'menu_link' => Yii::app()->createUrl('/affilliate/affilliate/index'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-user',
                ),
            );
            $addition += array(
                'affilliate_link' => array(
                    'menu_title' => Yii::t('affilliate', 'affilliate_link'),
                    'menu_link' => Yii::app()->createUrl('/affilliate/affilliate/link'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-user',
                ),
            );
        }
        if (UsersAffilliate::isSupperAdmin()) {
            // $addition += array(
            //     'admin' => array(
            //         'menu_title' => Yii::t('user', 'user_admin'),
            //         'menu_link' => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'),
            //         'items' => false,
            //         'active' => false,
            //         'iconclass' => 'icon-user',
            //     ),
            // );
        }
        $this->data = $addition;
        //
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'data' => $this->data,
            'first' => $this->first,
            'module' => $this->module,
        ));
    }
}
