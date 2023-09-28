<?php

/**
 * menu chỉ hiển thị theo chiều dọc
 */
class menu_vertical extends WWidget {

    public $group_id = 0;
    public $parent_id = 0;
    public $directfrom = '';
    public $data = array(); // category info and its listnews
    protected $view = 'view'; // view of widget
    protected $name = 'menu_vertical';
    protected $first = true;
    protected $config = array();

    public function init() {
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.menu_vertical.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // Load config
        $config_menu_vertical = new config_menu_vertical('', array('page_widget_id' => $this->page_widget_id));
        if ($config_menu_vertical->group_id)
            $this->group_id = $config_menu_vertical->group_id;
        if ($config_menu_vertical->widget_title)
            $this->widget_title = $config_menu_vertical->widget_title;
        if (isset($config_menu_vertical->show_wiget_title))
            $this->show_widget_title = $config_menu_vertical->show_wiget_title;
        if ($config_menu_vertical->directfrom && $config_menu_vertical->directfrom == Menus::MENU_DIRECT_RIGHT)
            $this->directfrom = $config_menu_vertical->directfrom;
        //
        if (!$this->data || !count($this->data)) {
            $clamenu_vertical = new ClaMenu(array(
                'create' => true,
                'group_id' => $this->group_id,
            ));
            $this->data = $clamenu_vertical->createMenu($this->parent_id);
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'directfrom' => $this->directfrom,
            'parent_id' => $this->parent_id,
            'first' => $this->first,
        ));
    }

}
