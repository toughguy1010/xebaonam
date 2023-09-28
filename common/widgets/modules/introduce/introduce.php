<?php

/**
 * Description of wglobal 
 * Widget chung để hiển thị các widget khác 
 *
 * @author minhbn
 */
class introduce extends WWidget {

    //put your code here
    public $type = 1; // 1: lấy giới thiệu của site làm bài giới thiệu, 2: cho phép người dùng tự cấu hình giới thiệu
    public $view = '';
    protected $viewlabel = 'view';
    protected $config = array();
    protected $data = array();

    public function init() {
        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.introduce.' . $this->viewlabel . $this->type;
        if ($this->controller->getViewFile($viewname)) {
            $this->view = $viewname;
        } else
            $this->view = $this->viewlabel . $this->type;
        parent::init();
    }

    public function run() {
        if ($this->beginContent)
            echo $this->beginContent;
        //
        foreach ($this->widgets as $widget) {
            Widgets::renderWidget($widget);
        }
        //
        if ($this->endContent)
            echo $this->endContent;
    }

}
