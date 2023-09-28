<?php

/**
 * Hiển thị danh sách province showinhome
 */
class tourProvinceInHome extends WWidget {

    public $provinceinhome = array(); // categories is show in home
    public $data = array(); // group info and its list hotel
    public $limit = 5; // Giới hạn các tập đoàn trong trang chủ
    protected $name = 'tourProvinceInHome'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_tourProvinceInHome = new config_tourProvinceInHome('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_tourProvinceInHome->limit)) {
            $this->limit = (int) $config_tourProvinceInHome->limit;
        }
        if ($config_tourProvinceInHome->widget_title) {
            $this->widget_title = $config_tourProvinceInHome->widget_title;
        }
        if (isset($config_tourProvinceInHome->show_wiget_title)) {
            $this->show_widget_title = $config_tourProvinceInHome->show_wiget_title;
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        // get categories in home
        $this->provinceinhome = TourProvinceInfo::getProvinceInHome(array('limit' => $this->limit));
        // Get news in category
        if ($this->provinceinhome && count($this->provinceinhome)) {
            foreach ($this->provinceinhome as $province) {
                $this->data[$province['id']] = $province;
                $count_hotel = TourHotel::countHotelInProvince($province['province_id']);
                $this->data[$province['id']]['count_hotel'] = $count_hotel;
            }
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'provinceinhome' => $this->provinceinhome,
            'data' => $this->data,
        ));
    }

}
