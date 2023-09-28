<?php

/*
 * @Author: MinhBN
 * @email: minhbachngoc@orenj.com
 * @date: 12/30/2013
 * 
 * @description: to show the left of main layout
 */

class LeftLayout extends CWidget {

    public $data;
    public $first = true;
    public $module;
    protected $view = 'layoutleft';
    protected $parent_id = 0;

    public function init() {
        $clamenu = new ClaAdminMenu(array(
            'create' => true,
        ));
        $this->data = $clamenu->createMenu($this->parent_id, $options);
        if (isset($options['track'])) {
            $this->data = $clamenu->browseActive($this->data, $options['track']);
        }
        $addition = array();
        if(ClaUser::isSupperAdmin() || Yii::app()->controller->admin->isRoot()){
            $addition = array(
                  'admin' => array(
                    'menu_title' => Yii::t('user','user_admin'),
                    'menu_link' => Yii::app()->createUrl('/useradmin/useradmin'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-user',
                ),
            );
        }
        if (Yii::app()->user->id == ClaUser::SUPPER_ADMIN_ID) {
            $addition += array(
                'productattribute' => array(
                    'menu_title' => 'Thuộc tính sản phẩm',
                    'menu_link' => Yii::app()->createUrl('economy/productAttribute'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-file-powerpoint-o',
                ),
                'productAttributeSet' => array(
                    'menu_title' => 'Nhóm thuộc tính',
                    'menu_link' => Yii::app()->createUrl('economy/productAttributeSet'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-cubes',
                ),
                'customform' => array(
                    'menu_title' => Yii::t('form', 'form_manager'),
                    'menu_link' => Yii::app()->createUrl('/custom/customform'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-th',
                ),
                'postcategory' => array(
                    'menu_title' => Yii::t('category', 'category_post'),
                    'menu_link' => Yii::app()->createUrl('/content/postcategory'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-folder-open',
                ),
                'adminmenu' => array(
                    'menu_title' => Yii::t('menu', 'menu_manager'),
                    'menu_link' => Yii::app()->createUrl('setting/sitemenu'),
                    'items' => false,
                    'active' => false,
                    'iconclass' => 'icon-list-ul',
                ),
            );
            //
        }
        $this->data +=$addition;
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'first' => $this->first,
            'module' => $this->module,
        ));
    }

}
