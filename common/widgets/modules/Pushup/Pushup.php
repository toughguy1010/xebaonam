<?php

/**
 * @author minhbn
 */
class Pushup extends WWidget {

    public $type = ClaPushup::type_onesignal;
    protected $options=array();
    protected $name = 'Pushup'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $siteinfo = Yii::app()->siteinfo;
        //
        $config_Pushup = new config_Pushup('', array('page_widget_id' => $this->page_widget_id));
        if ($config_Pushup) {
            $this->widget_title = $config_Pushup->widget_title;
            $this->show_widget_title = $config_Pushup->show_wiget_title;
            $this->type = $config_Pushup->type;
        }
        //
        $claPushup = new ClaPushup(array('type'=>  $this->type));
        $this->options = $claPushup->getOptions();
        //
        $this->view = $this->view . $this->type;
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
            'options' => $this->options,
            'type' => $this->type,
        ));
    }

}
