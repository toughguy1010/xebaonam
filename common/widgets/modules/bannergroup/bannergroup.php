<?php

class bannergroup extends WWidget
{

    public $banner_group_id = 0; // category info and its listnews
    public $banner_group_info = 0; // category info and its listnews
    public $banners = array();
    public $bannerGroup = null;
    public $style = '';
    public $timeDelay = 4000;
    protected $view = 'view';
    protected $name = 'bannergroup';
    protected $id = 'bg';
    protected $enable_start_end_time = 0;
    protected $bannerLimit = null; // giới hạn số banner lấy trong nhóm
    protected $assets = '';
    public $disable_js_default = 0;

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_bannergroup = new config_bannergroup('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_bannergroup->banner_group_id) && $config_bannergroup->banner_group_id) {
            $this->enable_start_end_time = $config_bannergroup->enable_start_end_time;
            $this->banner_group_id = $config_bannergroup->banner_group_id;
            $this->bannerGroup = BannerGroups::model()->findByPk($this->banner_group_id);
            $this->banners = Banners::getBannersInGroup($this->banner_group_id,
                array('limit' => $config_bannergroup->limit, 'enable_start_end_time' => $config_bannergroup->enable_start_end_time));
            $this->banners = Banners::filterBanners($this->banners);
            $this->widget_title = $config_bannergroup->widget_title;
            $this->show_widget_title = $config_bannergroup->show_wiget_title;
            $this->style = $config_bannergroup->style;
            $this->timeDelay = $config_bannergroup->timeDelay;
            $this->disable_js_default = $config_bannergroup->disable_js_default;
        }
        if ($this->style)
            $this->view = $this->view . '_' . $this->style;
        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        $this->id .= $this->page_widget_id;
        //
        //Hatv disable_js_default if custom
        if ($this->disable_js_default != 1) {
            $this->registerClientScript();
        }
        parent::init();
    }

    public function run()
    {
        if (!$this->disable_js_default) {
            switch ($this->style) {
                case 'default': {
                    Yii::app()->clientScript->registerScript("style_" . $this->style, ''
                        . "
                                var id = (jQuery('#" . $this->id . "').length)?'#" . $this->id . " ':'';
                                var jcarousel = $(id+'.jcarousel').jcarousel({wrap: 'circular'}); 
                                $(id+'.jcarousel').jcarouselAutoscroll({autostart: true,interval: " . $this->timeDelay . ",target: '+=1', create: $(id+'.jcarousel').hover(function(){ $(this).jcarouselAutoscroll('stop');}, function(){ $(this).jcarouselAutoscroll('start');})});
            $(id+'.jcarousel-control-prev').on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $(id+'.jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });", CClientScript::POS_END);
                }
                    break;
                case 'style1': {
                    Yii::app()->clientScript->registerScript("style_" . $this->style, ''
                        . "
                                var id = (jQuery('#" . $this->id . "').length)?'#" . $this->id . " ':'';
                                var jcarousel = $('.jcarousel').jcarousel({wrap: 'circular'}); 
                                $(id+'.jcarousel').jcarouselAutoscroll({autostart: true,interval: " . $this->timeDelay . ",target: '+=1'});
                                $(id+'.jcarousel-control-prev').on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $(id+'.jcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
                                 $(id+'.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href=\"#' + page + '\">' + page + '</a>';
                }
            });
         ", CClientScript::POS_END);
                }
                    break;
                case 'style2': {
                    Yii::app()->clientScript->registerScript("style_" . $this->style, ''
                        . ' $(document).ready(function() {
                                var iid = (jQuery("#' . $this->id . '").length)?"#' . $this->id . ' ":"";
                        $(iid+".ivslider").iView({
                            pauseTime: ' . $this->timeDelay . ',
                            pauseOnHover: true,
                            directionNav: true,
                            directionNavHide: false,
                            directionNavHoverOpacity: 0,
                            controlNav: true,
                            nextLabel: "next",
                            previousLabel: "prev",
                            timer: "Pie",
                            timerPadding: 3,
                            timerColor: "#FEFEFE"
                        });
                    });', CClientScript::POS_END);
                }
                    break;
            }
        }
        $this->render($this->view, array(
            'banners' => $this->banners,
            'info' => $this->bannerGroup,
            'bannerGroup' => $this->bannerGroup,
            'style' => $this->style,
            'id' => $this->id,
            'assets' => $this->assets,
        ));
    }

    public function registerClientScript()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            if (!defined("BANNERGROUP_REGISTERSCRIPT_" . $this->style)) {
                define("BANNERGROUP_REGISTERSCRIPT_" . $this->style, true);
                $this->assets = $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
                $client = Yii::app()->clientScript;
                if ($this->style != 'style3')
                    $js = $client->registerScriptFile($assets . '/' . $this->style . "/js/script.js", CClientScript::POS_END);
                if ($this->style == 'style2')
                    $css = $client->registerCssFile($assets . '/' . $this->style . "/css/style.css");
            }
        }
    }

}
