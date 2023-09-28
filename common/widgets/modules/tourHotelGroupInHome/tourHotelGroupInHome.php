<?php

/**
 * Tập đoàn và các khách sạn trong tập đoàn đó
 */
class tourHotelGroupInHome extends WWidget {

    public $groupinhome = array(); // categories is show in home
    public $data = array(); // group info and its list hotel
    public $limit = 5; // Giới hạn các tập đoàn trong trang chủ
    public $itemslimit = 8; // Giới hạn khách sạn trong tập đoàn
    protected $name = 'tourHotelGroupInHome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_tourHotelGroupInHome = new config_tourHotelGroupInHome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_tourHotelGroupInHome->limit)) {
            $this->limit = (int) $config_tourHotelGroupInHome->limit;
        }
        if ($config_tourHotelGroupInHome->itemslimit) {
            $this->itemslimit = $config_tourHotelGroupInHome->itemslimit;
        }
        if ($config_tourHotelGroupInHome->widget_title) {
            $this->widget_title = $config_tourHotelGroupInHome->widget_title;
        }
        if (isset($config_tourHotelGroupInHome->show_wiget_title)) {
            $this->show_widget_title = $config_tourHotelGroupInHome->show_wiget_title;
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get categories in home
        $this->groupinhome = TourHotelGroup::getHotelGroupInHome(array('limit' => $this->limit));
        // Get news in category
        foreach ($this->groupinhome as $group) {
            $this->data[$group['id']] = $group;
            $listhotel = TourHotel::getHotelInGroup($group['id'], array('limit' => $this->itemslimit));
            $this->data[$group['id']]['hotels'] = $listhotel;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'groupinhome' => $this->groupinhome,
            'data' => $this->data,
        ));
    }

}
