<?php

class tourrelation extends WWidget
{

    public $limit = 0;
    protected $listtour = array();
    protected $view = 'view'; // view of widget
    protected $name = 'tourrelation';
    protected $tour_id = '';
    protected $linkkey = 'tour/tour/detail';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        // set name for widget, default is class name
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.tourrelation.view';
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
        // Load config
        $config_tourrelation = new config_tourrelation('', array('page_widget_id' => $this->page_widget_id));
        if ($config_tourrelation->widget_title)
            $this->widget_title = $config_tourrelation->widget_title;
        if (isset($config_tourrelation->show_wiget_title))
            $this->show_widget_title = $config_tourrelation->show_wiget_title;
        if ($config_tourrelation->limit)
            $this->limit = $config_tourrelation->limit;
        //
        if ($this->linkkey == ClaSite::getLinkKey())
            $this->tour_id = Yii::app()->request->getParam('id');
        //
        if ($this->tour_id) {
            $tour = Tour::model()->findByPk($this->tour_id);
            if ($tour) {
                $options = array(
                    'limit' => $this->limit,
                    'tour_id' => $this->tour_id,
                    'category_id' => $tour->tour_category_id
                );
                $this->listtour = Tour::getRelationTours($options);
            }
        }
        parent::init();
    }

    public
    function run()
    {
        $this->render($this->view, array(
            'listtour' => $this->listtour,
        ));
    }

}
