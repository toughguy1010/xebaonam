<?php

/**
 * Hiển thị các vé mới nhất
 */
class AirlineTicketNewWidget extends WWidget {

    public $tickets = array();
    public $limit = 5;
    protected $name = 'AirlineTicketNewWidget'; // name of widget
    protected $view = 'view'; // view of widget
    public $locations = array();

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_AirlineTicketNewWidget = new config_AirlineTicketNewWidget('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_AirlineTicketNewWidget->widget_title;
        $this->show_widget_title = $config_AirlineTicketNewWidget->show_wiget_title;
        $this->limit = $config_AirlineTicketNewWidget->limit;
        //
        // get new tickets
        $this->tickets = AirlineTicket::getTicketAll(array('limit' => $this->limit));
        //
        $this->locations = AirlineLocation::getLocationAll();
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
            'tickets' => $this->tickets,
            'locations' => $this->locations
        ));
    }

}
