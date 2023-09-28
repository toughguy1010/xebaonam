<?php

/**
 * Hiển thị form tùy chỉnh
 */
class customform extends WWidget {

    public $form_id = 0; // Loại form gì
    public $labelClass = 2; // Class for label (col-sm-2, col-sm-3....)
    protected $fields = array();
    protected $model = null;
    protected $basepath = '';
    protected $name = 'customform'; // name of widget
    protected $view = 'view'; // view of widget
    protected $data = null;
    protected $helptext = '';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_customform = new config_customform('', array('page_widget_id' => $this->page_widget_id));
        if ($config_customform->widget_title)
            $this->widget_title = $config_customform->widget_title;
        if (isset($config_customform->show_wiget_title))
            $this->show_widget_title = $config_customform->show_wiget_title;
        //
        if (isset($config_customform->helptext))
            $this->helptext = $config_customform->helptext;
        if ($config_customform->form_id) {
            $this->form_id = $config_customform->form_id;
            $this->fields = FormFields::getFieldsInForm($this->form_id);
            $this->model = new AutoForm();
            $this->model->loadFields($this->fields);
            $this->data = Forms::model()->findByPk($this->form_id);
        }
        //
        if (isset($config_customform->labelClass)){
            $this->labelClass = $config_customform->labelClass;
        }
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->basepath = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name;
//            $this->view = $viewname;
//            // get hot news
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
            $themename = Yii::app()->theme->name;
            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
            $this->basepath = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name;
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'helptext' => $this->helptext,
            'form_id' => $this->form_id,
            'fields' => $this->fields,
            'model' => $this->model,
            'basepath' => $this->basepath,
            'labelClass' => $this->labelClass,
            'data' => $this->data
        ));
    }

}
