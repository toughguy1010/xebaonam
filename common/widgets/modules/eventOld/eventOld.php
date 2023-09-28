<?php

/**
 * @author hungtm
 */
class eventOld extends WWidget
{

    public $events;
    public $limit = 5;
    public $show_via_hot_order = null;
    protected $name = 'eventOld'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_event = new config_eventOld('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_event->widget_title;
        $this->show_widget_title = $config_event->show_wiget_title;
        $this->limit = $config_event->limit;
        if ($config_event->show_via_hot_order) {
            $this->show_via_hot_order = $config_event->show_via_hot_order;
        }
        //
        // get course new

        if (!$this->show_via_hot_order) {
            $this->events = Event::getOldEvent(array('limit' => $this->limit));
        } else {
//            $this->events = Event::getEventNearOpen(array('limit' => $this->limit,'start_date'=>date('Y-m-d',time())));
            $this->events = Event::getOldEvent(array('limit' => $this->limit, 'is_hot' => true));
        }
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
            'events' => $this->events,
        ));
    }

}
