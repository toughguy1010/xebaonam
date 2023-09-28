<?php

/**
 * menu cho phép người dùng chọn style
 */
class MenuStyle extends WWidget {

    public $group_id = 0;
    public $parent_id = 0;
    public $directfrom = '';
    public $menu_title = ''; // Tiêu đề của menu để khi thu nhỏ sẽ hiển thị ra
    public $style = ''; // style name
    public $data = array(); // menu data
    //
    protected $view = 'view'; // view of widget
    protected $name = 'MenuStyle';
    protected $first = true;
    protected $config = array();
    protected $level = 0;
    protected $cols = 1;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_MenuStyle = new config_MenuStyle('', array('page_widget_id' => $this->page_widget_id));
        if ($config_MenuStyle->group_id)
            $this->group_id = $config_MenuStyle->group_id;
        if ($config_MenuStyle->widget_title)
            $this->widget_title = $config_MenuStyle->widget_title;
        if (isset($config_MenuStyle->show_wiget_title))
            $this->show_widget_title = $config_MenuStyle->show_wiget_title;
        if ($config_MenuStyle->directfrom && $config_MenuStyle->directfrom == Menus::MENU_DIRECT_RIGHT)
            $this->directfrom = $config_MenuStyle->directfrom;
        if ($config_MenuStyle->style)
            $this->style = $config_MenuStyle->style;
        //
        if (!$this->data || !count($this->data)) {
            $claMenuStyle = new ClaMenu(array(
                'create' => true,
                'group_id' => $this->group_id,
            ));
            $this->data = $claMenuStyle->createMenu($this->parent_id);
        }
        //
        if ($this->style)
            $this->view = $this->view . '_' . $this->style;
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        $this->registerClientScript();
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'directfrom' => $this->directfrom,
            'menu_title' => $this->menu_title,
            'parent_id' => $this->parent_id,
            'first' => $this->first,
            'cols' => $this->cols,
        ));
    }

    /**
     * 
     */
    public function registerClientScript() {
        if (!Yii::app()->request->isAjaxRequest) {
            if (!defined("BANNERGROUP_REGISTERSCRIPT_" . $this->style)) {
                define("BANNERGROUP_REGISTERSCRIPT_" . $this->style, true);
                $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
                $client = Yii::app()->clientScript;
                $js = $client->registerScriptFile($assets . '/' . $this->style . "/js/script.js", CClientScript::POS_END);
                $css = $client->registerCssFile($assets . '/' . $this->style . "/css/style.css");
            }
        }
    }

}
