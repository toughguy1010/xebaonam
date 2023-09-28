<?php

class HpDoctorSearch extends WWidget {

    public $limit = 10;
    public $totalitem = 0;
    public $educations = array();
    public $faculties = array();
    public $languages = array();
    protected $name = 'HpDoctorSearch'; // name of widget
    protected $view = 'view'; // view of widget
    public $gender = '';
    public $lang = '';
    public $n = '';
    public $faculty = '';
    public $edu = '';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $config_HpDoctorSearch = new config_HpDoctorSearch('', array('page_widget_id' => $this->page_widget_id));
        //
        if ($config_HpDoctorSearch->widget_title) {
            $this->widget_title = $config_HpDoctorSearch->widget_title;
        }
        if (isset($config_HpDoctorSearch->show_wiget_title)) {
            $this->show_widget_title = $config_HpDoctorSearch->show_wiget_title;
        }
        // Params Search
        $this->n = Yii::app()->request->getParam('n', '');
        $this->faculty = Yii::app()->request->getParam('faculty', '');
        $this->gender = Yii::app()->request->getParam('gender', '');
        $this->edu = Yii::app()->request->getParam('edu', '');
        $this->lang = Yii::app()->request->getParam('lang', '');
        //
        $this->educations = HpEducation::optionEducation(array('' => 'Trình độ học vấn'));
        $this->faculties = HpFaculty::optionFaculty(array('' => 'Chọn chuyên khoa'));
        $this->languages = HpLanguage::getLanguageArr(array('' => 'Chọn ngôn ngữ'));
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
            'educations' => $this->educations,
            'faculties' => $this->faculties,
            'languages' => $this->languages,
            'n_compare' => $this->n,
            'faculty_compare' => $this->faculty,
            'gender_compare' => $this->gender,
            'edu_compare' => $this->edu,
            'lang_compare' => $this->lang
        ));
    }

}
