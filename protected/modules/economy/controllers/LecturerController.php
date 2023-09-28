<?php

class LecturerController extends PublicController {

    public $layout = '//layouts/lecturer';

    /**
     * lecturer index
     */
    public function actionIndex() {
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_LECTURER);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->pageTitle = $this->metaTitle = $seo->meta_title;
        }
        //
        $this->layoutForAction = '//layouts/lecturer_index';
        //
        $this->breadcrumbs = array(
            Yii::t('course', 'lecturer') => Yii::app()->createUrl('/economy/lecturer'),
        );
        $this->render('index');
    }

    /**
     * View lecturer detail
     */
    public function actionDetail($id) {
        $lecturer = Lecturer::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('course', 'lecturer') => Yii::app()->createUrl('/economy/lecturer'),
            $lecturer['name'] => Yii::app()->createUrl('/economy/lecturer/detail', array('id' => $id)),
        );
        if (!$lecturer || $lecturer['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($lecturer['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

        $this->pageTitle = $this->metakeywords = $lecturer['name'];
        $this->metadescriptions = $lecturer['sort_description'];

        if ($lecturer['avatar_path'] && $lecturer['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $lecturer['avatar_path'] . 's1000_1000/' . $lecturer['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        //

        $this->render('detail', array(
            'lecturer' => $lecturer,
        ));
    }

}

?>