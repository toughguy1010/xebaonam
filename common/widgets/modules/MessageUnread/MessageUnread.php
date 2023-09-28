<?php

/**
 * Hiển thị số message chưa đọc
 */
class MessageUnread extends WWidget {

    public $count = 0;
    protected $name = 'MessageUnread'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_MessageUnread = new config_MessageUnread('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_MessageUnread->widget_title;
        $this->show_widget_title = $config_MessageUnread->show_wiget_title;
        //
        // get list sender and his last message
        $this->count = Message::countUnreadedMessage(Yii::app()->user->id);
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
            'count' => $this->count,
        ));
    }

}
