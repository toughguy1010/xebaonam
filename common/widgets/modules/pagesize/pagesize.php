<?php

/**
 * Hiển thị số bản ghi trên trang
 */
class pagesize extends WWidget {

    protected $options = array();
    protected $summaryText = '';
    protected $afterText = '';
    protected $pageSize = 10;
    protected $url = '';
    protected $name = 'pagesize'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_pagesize = new config_pagesize('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_pagesize->limit))
            $this->limit = (int) $config_pagesize->limit;
        if ($config_pagesize->widget_title)
            $this->widget_title = $config_pagesize->widget_title;
        if (isset($config_pagesize->show_wiget_title))
            $this->show_widget_title = $config_pagesize->show_wiget_title;
        if (isset($config_pagesize->summaryText))
            $this->summaryText = $config_pagesize->summaryText;
        if (isset($config_pagesize->afterText))
            $this->afterText = $config_pagesize->afterText;
        if (isset($config_pagesize->pageSize))
            $this->pageSize = $config_pagesize->pageSize;

        $this->options = $config_pagesize->getPageOptions();
        //
        $pageSize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if ($pageSize)
            $this->pageSize = $pageSize;
        //
        $params = $_GET;
        if ($params)
            unset($params[ClaSite::PAGE_SIZE_VAR]);
        else
            $params = array();
        $params = ClaArray::AddArrayToEnd($params, array(ClaSite::PAGE_SIZE_VAR => ''));
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
            'pageSize' => $this->pageSize,
            'url' => $this->url,
        ));
    }

}
