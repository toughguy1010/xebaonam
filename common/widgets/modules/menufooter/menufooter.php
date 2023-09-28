<?php

/**
 * Menu hay hiển thị ở footer
 */
class menufooter extends WWidget {

    public $group_id = 0;
    public $parent_id = 0; // Menu cha
    public $cols = 1; // Số cột hiển thị trong menu
    public $rows = 1; // Số hàng mỗi cột
    public $data = array(); // category info and its listnews
    protected $view = 'view'; // view of widget
    protected $name = 'menufooter';
    protected $first = true;
    protected $level = 0;
    protected $colItemClass = '';
    protected $config = array();

    public function init() {
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.menufooter.view';
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
        $config_menufooter = new config_menufooter('', array('page_widget_id' => $this->page_widget_id));
        if ($config_menufooter->group_id)
            $this->group_id = $config_menufooter->group_id;
        if ($config_menufooter->widget_title)
            $this->widget_title = $config_menufooter->widget_title;
        if (isset($config_menufooter->show_wiget_title))
            $this->show_widget_title = $config_menufooter->show_wiget_title;
        if ($config_menufooter->cols)
            $this->cols = $config_menufooter->cols;
        if ($config_menufooter->rows)
            $this->rows = $config_menufooter->rows;
        //
        $this->colItemClass = 'col-sm-' . (ceil(Menus::MENU_COLSMAX / $this->cols));
        //
        if (!$this->data || !count($this->data)) {
            $clamenufooter = new ClaMenu(array(
                'create' => true,
                'group_id' => $this->group_id,
            ));
            $this->data = $clamenufooter->createMenu($this->parent_id);
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'parent_id' => $this->parent_id,
            'first' => $this->first,
            'level' => $this->level,
            'rows' => $this->rows,
            'cols' => $this->cols,
            'colItemClass' => $this->colItemClass,
        ));
    }

}
