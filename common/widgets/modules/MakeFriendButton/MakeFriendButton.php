<?php

/**
 * Hiển thị số message chưa đọc
 */
class MakeFriendButton extends WWidget {

    public $friendFieldId = '';
    public $friendId = '';
    protected $status = false;
    protected $name = 'MakeFriendButton'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
//        $config_MakeFriendButton = new config_MakeFriendButton('', array('page_widget_id' => $this->page_widget_id));
//        $this->widget_title = $config_MakeFriendButton->widget_title;
//        $this->show_widget_title = $config_MakeFriendButton->show_wiget_title;

        if ($this->friendFieldId && !$this->friendId) {
            $this->friendId = Yii::app()->request->getParam($this->friendFieldId);
        }
        if ($this->friendId) {
            $this->status = UserFriends::getFriendStatus(Yii::app()->user->id, $this->friendId);
        }
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
