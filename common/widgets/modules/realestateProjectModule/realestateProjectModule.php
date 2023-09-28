<?php

class realestateProjectModule extends WWidget {

    public $data = array(); 
    protected $view = 'view'; 
    public $url_return;

    public function init() {
        parent::init();
    }

    public function run() {
        $site_id = Yii::app()->controller->site_id;
        $projects = array();
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('real_estate_project'))
                ->where('site_id=:site_id AND status=:status', array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
        $pagesize = 10000;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (count($data)) {
            foreach ($data as $key => $project) {
                $projects[$key] = $project;
                $projects[$key]['link'] = Yii::app()->createUrl('news/realestate/project', array('id' => $project['id'], 'alias' => $project['alias']));
                $projects[$key]['realestates'] = RealEstate::getRealestateInProject($project['id'], array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                ));
            }
        }
        
        $this->render($this->view, array(
            'projects' => $projects,
        ));
    }

}
