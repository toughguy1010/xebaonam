<?php

// Album Detail
class popupregisterproduct extends WWidget {

    protected $name = 'popupregisterproduct'; // name of widget
    protected $view = 'view'; // view of widget
    public $popup_id = [];
    public $popup = [];

    public function init() {

        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_popupregisterproduct = new config_popupregisterproduct('', array('page_widget_id' => $this->page_widget_id));
        if ($config_popupregisterproduct->widget_title) {
            $this->widget_title = $config_popupregisterproduct->widget_title;
        }
        if (isset($config_popupregisterproduct->show_wiget_title)) {
            $this->show_widget_title = $config_popupregisterproduct->show_wiget_title;
        }
        if (isset($config_popupregisterproduct->album_id)) {
            $this->album_id = $config_popupregisterproduct->album_id;
        }

        //
        if ($this->popup_id) {
            $popup = PopupRegisterProducts::model()->findByPk($this->popup_id);
            $this->popup = $popup;
        } else {
            $popups = PopupRegisterProducts::getPopupModelALl();
            if($popups) {
                $tg = rand(0, count($popups) -1);
                $this->popup = $popups[round($tg)];
            }
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

    public function run() {
        $listprovince = Province::getAllProvinceArr(false);
        $form_regiters = new PopupRegisterProductForm(); 
        $this->render($this->view, array(
            'popup' => $this->popup,
            'form_regiters' => $form_regiters,
            'listprovince' => $listprovince,
        ));
    }

}
