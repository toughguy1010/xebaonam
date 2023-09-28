<?php

class carFilter extends WWidget {

    protected $name = 'carFilter'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_carFilter = new config_carFilter('', array('page_widget_id' => $this->page_widget_id));
        if ($config_carFillter->widget_title)
            $this->widget_title = $config_carFilter->widget_title;
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
        $data['categories'] = Car::optionCats();
        $data['prices'] = Car::optionPrices();
        $data['fuels'] = Car::optionFuel();
        $data['seats'] = Car::optionSeat();
        $data['styles'] = Car::optionStyle();
        $data['madeins'] = Car::optionMadein();
        $data['link_filter'] = Yii::app()->createUrl('/car/car/indexajax');
        $this->render($this->view, array(
            'data' => $data,
        ));
    }

}
