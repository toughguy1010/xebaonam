<?php

class social extends WWidget {

    public $data = array();
    public $link = '';
    protected $view = 'view';
    protected $name = 'social';

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // Load config
        $config_social = new config_social('', array('page_widget_id' => $this->page_widget_id));
        if ($config_social) {
            $this->widget_title = $config_social->widget_title;
        }
        //
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.social.' . $this->view;
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        if (!defined("SOCIAL_FACEBOOK")) {
            define("SOCIAL_FACEBOOK", true);
            if (isset(Yii::app()->siteinfo['app_id']) && Yii::app()->siteinfo['app_id']) {
                echo '<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=', Yii::app()->siteinfo['app_id'], '&version=v3.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
            } else {
                echo '<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>';
            }
        }

        //
        if (!defined("SOCIAL_GOOGLEPLUS")) {
            define('SOCIAL_GOOGLEPLUS', true);
            echo '<script src="https://apis.google.com/js/platform.js" async defer></script>';
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'link' => $this->link,
        ));
    }

}
