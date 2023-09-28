<?php

class onebanner extends WWidget {

    public $src = ''; // category info and its listnews
    public $type = null; // Có 2 loại banner, loại baner ảnh và loại banner flash
    public $link = '';
    public $width = 0;
    public $height = 0;
    public $target = '';
    public $description = '';
    protected $view = ''; // view of widget
    protected $name = 'onebanner';
    protected $show = true;

    public function init() {
        $this->type = Banners::BANNER_TYPE_IMAGE;
        //
        $this->view = 'view_' . $this->type;
        // Load config
        $config_onebanner = new config_onebanner('', array('page_widget_id' => $this->page_widget_id));
        if ($config_onebanner->banner_id) {
            $banner = Banners::getBannerData($config_onebanner->banner_id);
            if (!$banner || !Banners::checkShowBanner($banner))
                $this->show = false;
            if (count($banner) && $this->show) {
                if (isset($banner['banner_src']))
                    $this->src = $banner['banner_src'];
                if (isset($banner['banner_type']))
                    $this->type = $banner['banner_type'];
                if (isset($banner['banner_link']))
                    $this->link = $banner['banner_link'];
                if (isset($banner['banner_width']))
                    $this->width = $banner['banner_width'];
                if (isset($banner['banner_height']))
                    $this->height = $banner['banner_height'];
                if (isset($banner['banner_description']))
                    $this->description = $banner['banner_description'];
                if (isset($banner['banner_target']))
                    $this->target = Banners::getTarget($banner);
            }
            $this->widget_title = $config_onebanner->widget_title;
            $this->show_widget_title = $config_onebanner->show_wiget_title;
            // set name for widget, default is class name
//            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//            $themename = Yii::app()->theme->name;
//            $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.onebanner.' . $this->view;
//            //
//            if ($this->controller->getViewFile($viewname)) {
//                $this->view = $viewname;
//            }
            $viewname = $this->getViewAlias(array(
                'view' => $this->view,
                'name' => $this->name,
            ));
            if ($viewname != '') {
                $this->view = $viewname;
            }
        }
        parent::init();
    }

    public function run() {
        if ($this->show) {
            $this->render($this->view, array(
                'src' => $this->src,
                'link' => $this->link,
                'type' => $this->type,
                'width' => $this->width,
                'height' => $this->height,
                'description' => $this->description,
                'target' => $this->target,
            ));
        }
    }

}
