<?php

class instagramFeed extends WWidget {

    public $data = array();
    public $link = '';
    protected $instagram_site = null;
    protected $view = 'view';
    protected $name = 'instagramFeed';
    protected $instagram_uid = null;
    protected $limit = 14;
    protected $access_token = null;
    protected $hastag = 0;

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_instagramFeed = new config_instagramFeed('', array('page_widget_id' => $this->page_widget_id));
        if ($config_instagramFeed) {
            $this->widget_title = $config_instagramFeed->widget_title;
            $this->instagram_uid = $config_instagramFeed->instagram_uid;
            $this->instagram_site = $config_instagramFeed->instagram_site;
            $this->limit = $config_instagramFeed->limit;
            $this->access_token = $config_instagramFeed->access_token;
            $this->hastag = $config_instagramFeed->hastag;
            if ($this->hastag != 0 ) {
                $json_link = 'https://api.instagram.com/v1/tags/' . $this->instagram_uid . '/media/recent/?';
                $json_link.='access_token=' . $this->access_token . '&count=' . $this->limit;
            } else {
                $json_link = 'https://api.instagram.com/v1/users/' . $this->instagram_uid . '/media/recent/?';
                $json_link.='access_token=' . $this->access_token . '&count=' . $this->limit;
            }
            $curl = new ClaCurl();
            $curl->setConnectTimeout(5);
             $json = $curl->get($json_link);
//            $json = @file_get_contents($json_link);
            if ($json && $json != null) {
                $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
                $this->data = $obj;
            }
        }
        if (isset($config_instagramFeed->show_wiget_title))
            $this->show_widget_title = $config_instagramFeed->show_wiget_title;
        //
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        // set name for widget, default is class name
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'link' => $this->link,
            'instagram_site' => $this->instagram_site
        ));
    }

}
