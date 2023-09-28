<?php

class BdsProjectConfigController extends PublicController
{

    public $layout = '//layouts/bds';

    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/bds_index';
        //
        $this->breadcrumbs = array(
            Yii::t('site', 'bds_project_config') => Yii::app()->createUrl('/bds/bdsProjectConfig'),
        );
        $this->pageTitle = $this->metakeywords = Yii::t('site', 'bds_project_config');

        $this->render('index');
    }

    /**
     * BdsProjectConfig detail
     * @param type $id
     */
    public function actionDetail($id)
    {
        //
        $this->layoutForAction = '//layouts/bds_detail';
        //
        $consultants = BdsProjectConfig::getConsultantInRel($id);
        $project = BdsProjectConfig::model()->findByPk($id);
        if (!$project) {
            $this->sendResponse(404);
        }
        if ($project->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $images = $project->getImages();
        $this->pageTitle = $this->metakeywords = $project->name;
        $this->render('detail', array(
            'project' => $project,
            'images' => $images,
            'consultants' => $consultants
        ));
    }

}

?>