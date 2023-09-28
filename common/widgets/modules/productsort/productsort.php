<?php

/**
 * Sắp xếp sản phẩm
 */
class productsort extends WWidget {

    protected $options = array();
    protected $summaryText = '';
    protected $afterText = '';
    protected $url = '';
    protected $selected = '';
    protected $name = 'productsort'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_productsort = new config_productsort('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_productsort->limit))
            $this->limit = (int) $config_productsort->limit;
        if ($config_productsort->widget_title)
            $this->widget_title = $config_productsort->widget_title;
        if (isset($config_productsort->show_wiget_title))
            $this->show_widget_title = $config_productsort->show_wiget_title;
        if (isset($config_productsort->summaryText))
            $this->summaryText = $config_productsort->summaryText;
        if (isset($config_productsort->afterText))
            $this->afterText = $config_productsort->afterText;
        if (isset($config_productsort->selectedDefault))
            $this->selected = $config_productsort->selectedDefault;

        $this->options = $config_productsort->getPageOptions();
        //
        $sel = Yii::app()->request->getParam(ClaSite::PAGE_SORT);
        if ($sel !== false)
            $this->selected = $sel;
        //
        $params = $_GET;
        if ($params)
            unset($params[ClaSite::PAGE_SORT]);
        else
            $params = array();
        $params = ClaArray::AddArrayToEnd($params, array(ClaSite::PAGE_SORT => ''));
        //
        $this->url = Yii::app()->createUrl(Yii::app()->getController()->getRoute(), $params);
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
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
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'options' => $this->options,
            'summaryText' => $this->summaryText,
            'afterText' => $this->afterText,
            'selected' => $this->selected,
            'url' => $this->url,
        ));
    }

}
