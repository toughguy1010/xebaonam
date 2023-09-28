<?php

/**
 * Hiển thị danh sách những người nhắn tin cho mình phần tin nhắn của người đầu tiên nhắn cho mình
 */
class MessageGroupBySender extends WWidget {

    public $data = array();
    public $limit = 5;
    protected $name = 'MessageGroupBySender'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_MessageGroupBySender = new config_MessageGroupBySender('', array('page_widget_id' => $this->page_widget_id));
        $this->widget_title = $config_MessageGroupBySender->widget_title;
        $this->show_widget_title = $config_MessageGroupBySender->show_wiget_title;
        $this->limit = $config_MessageGroupBySender->limit;
        //
        // get list sender and his last message
        $this->data['friendMessage'] = Message::getMessagesGroupBySender(Yii::app()->user->id, array('limit' => $this->limit, 'friendInfo' => true));
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
            'data' => $this->data,
        ));
    }

}
