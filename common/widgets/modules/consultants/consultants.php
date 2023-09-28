<?php

/**
 * @author hungtm
 */
class consultants extends WWidget
{

    public $consultants;
    public $limit = 5;
    public $is_boss = 0;
    protected $name = 'consultants'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_consultants = new config_consultants('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_consultants->widget_title;
        $this->show_widget_title = $config_consultants->show_wiget_title;
        $this->limit = $config_consultants->limit;
        $this->is_boss = $config_consultants->is_boss;
        //
        // get course new
        $this->consultants = Consultant::getConsultants(array('limit' => $this->limit, 'is_boss' => $this->is_boss));
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

    public function run()
    {
        $this->render($this->view, array(
            'consultants' => $this->consultants,
        ));
    }

}
