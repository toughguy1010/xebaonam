<?php

class SiteInfoWidget extends WWidget {

    public $siteinfo;
    protected $name = 'SiteInfoWidget'; // name of widget
    public $view = 'view'; // view of widget
    public $showemail = 0;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_SiteInfoWidget = new config_SiteInfoWidget('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_SiteInfoWidget->limit)) {
            $this->limit = (int) $config_SiteInfoWidget->limit;
        }
        if ($config_SiteInfoWidget->widget_title) {
            $this->widget_title = $config_SiteInfoWidget->widget_title;
        }
        if (isset($config_SiteInfoWidget->show_wiget_title)) {
            $this->show_widget_title = $config_SiteInfoWidget->show_wiget_title;
        }
        //
        if (isset($config_SiteInfoWidget->style)) {
            $this->style = $config_SiteInfoWidget->style;
        }
        if (isset($config_SiteInfoWidget->showemail)) {
            $this->showemail = $config_SiteInfoWidget->showemail;
        }
        //
        $this->siteinfo = Yii::app()->siteinfo;
        //
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
            'siteinfo' => $this->siteinfo,
            'showemail' => $this->showemail
        ));
    }

}
