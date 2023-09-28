<?php

class menu extends WWidget {

    public $group_id = 0;
    public $parent_id = 0;
    public $directfrom = '';
    public $data = array(); // category info and its listnews
    public $cols = 1; // Số cột hiển thị trong menu
    protected $group = null;
    protected $view = 'view'; // view of widget
    protected $name = 'menu';
    protected $first = true;
    protected $config = array();
    protected $level = 0;
    protected $options = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.menu.view';
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
        $config_menu = new config_menu('', array('page_widget_id' => $this->page_widget_id));
        if ($config_menu->group_id) {
            $this->group_id = $config_menu->group_id;
            if (isset($config_menu->get_group_info) && $config_menu->get_group_info) {
                $this->group = MenuGroups::model()->findByPk($config_menu->group_id);
            }
        }
        if ($config_menu->widget_title) {
            $this->widget_title = $config_menu->widget_title;
        }
        if (isset($config_menu->show_wiget_title)) {
            $this->show_widget_title = $config_menu->show_wiget_title;
        }
        if (isset($config_menu->help_text)) {
            $this->help_text = $config_menu->help_text;
        }
        if ($config_menu->directfrom && $config_menu->directfrom == Menus::MENU_DIRECT_RIGHT)
            $this->directfrom = $config_menu->directfrom;
        //
        if (!$this->data || !count($this->data)) {
            $clamenu = new ClaMenu(array(
                'create' => true,
                'group_id' => $this->group_id,
            ));
            $this->data = $clamenu->createMenu($this->parent_id);
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'directfrom' => $this->directfrom,
            'parent_id' => $this->parent_id,
            'first' => $this->first,
            'cols' => $this->cols,
            'options' => $this->options,
            'help_text' => $this->help_text,
            'group' => $this->group,
        ));
    }

}
