<?php

/**
 * Banner controller
 */
class BannerController extends PublicController {

    public $layout = '//layouts/banner';

    /**
     * Lists all models.
     */
    public function actionGroup($id) {
        $group = BannerGroups::model()->findByPk($id);
        if (!$group) {
            $this->sendResponse(404);
        }
        if ($group->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            $group->banner_group_name => Yii::app()->createUrl('/media/banner/group'),
        );
        $this->pageTitle = $group->banner_group_name;
        //
        $banners = Banners::getBannersInGroup($id);
        //
        $this->render('group', array(
            'banners' => $banners,
        ));
    }

}
