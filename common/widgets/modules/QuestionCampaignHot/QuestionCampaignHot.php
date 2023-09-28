<?php

class QuestionCampaignHot extends WWidget {

    public $campaigns;
    public $limit = 5;
    protected $name = 'QuestionCampaignHot'; // name of widget
    public $view = 'view'; // view of widget

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $config_QuestionCampaignHot = new config_QuestionCampaignHot('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_QuestionCampaignHot->limit)) {
            $this->limit = (int) $config_QuestionCampaignHot->limit;
        }
        if ($config_QuestionCampaignHot->widget_title) {
            $this->widget_title = $config_QuestionCampaignHot->widget_title;
        }
        if (isset($config_QuestionCampaignHot->show_wiget_title)) {
            $this->show_widget_title = $config_QuestionCampaignHot->show_wiget_title;
        }
        //
        $this->campaigns = QuestionCampaign::getAllCampaigns(array(
                    'limit' => $this->limit,
                    'is_hot' => ActiveRecord::STATUS_ACTIVED
        ));
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        } elseif ($this->view != 'view') {
            $this->view = 'view';
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'campaigns' => $this->campaigns,
        ));
    }

}
