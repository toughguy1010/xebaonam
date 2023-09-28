<?php

/**
 * ContactForm
 * Only for exper
 * @author: Hatv
 */
class ExpertransContactForm extends WWidget
{

    public $form_id = 0; // Loại form gì
    public $labelClass = 2; // Class for label (col-sm-2, col-sm-3....)
    protected $fields = array();
    protected $model = null;
    protected $basepath = '';
    protected $name = 'ExpertransContactForm'; // name of widget
    protected $view = 'view'; // view of widget
    protected $data = null;
    protected $helptext = '';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_ExpertransContactForm = new config_ExpertransContactForm('', array('page_widget_id' => $this->page_widget_id));
        if ($config_ExpertransContactForm->widget_title)
            $this->widget_title = $config_ExpertransContactForm->widget_title;
        if (isset($config_ExpertransContactForm->show_wiget_title))
            $this->show_widget_title = $config_ExpertransContactForm->show_wiget_title;
        //
        if (isset($config_ExpertransContactForm->helptext))
            $this->helptext = $config_ExpertransContactForm->helptext;
        //
        if (isset($config_ExpertransContactForm->labelClass)) {
            $this->labelClass = $config_ExpertransContactForm->labelClass;
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        $this->model = new ExpertransContactFormModel();

        parent::init();
    }

    public function run()
    {
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
