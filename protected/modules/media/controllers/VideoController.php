<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * Editor: Hatv
 */
class VideoController extends PublicController {

    public $layout = "//layouts/video";

    /**
     * Lists all models.
     */
    public function actionAll() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('video', 'video') => Yii::app()->createUrl('/media/video/all'),
        );
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_VIDEO);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
        //
        $this->pageTitle = Yii::t('video', 'video');
        //
        $pagesize = MediaHelper::helper()->getPageSize();
        $page = MediaHelper::helper()->getCurrentPage();
        //
        $videos = Videos::getVideoInSite(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Videos::countVideoInSite();
        //
        $this->render('all', array(
            'videos' => $videos,
            'totalitem' => $totalitem,
        ));
    }

    public function actionDetail($id) {
        $this->layoutForAction = '//layouts/video_detail';
        $video = $this->loadModel($id);
        if (!$video)
            $this->sendResponse(404);
        if ($video->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        $cat = array();
        if ($video->cat_id) {
            $cat = VideosCategories::model()->findByPk($video->cat_id);
        }

        $this->pageTitle = $video->video_title;
        $this->metakeywords = $video->video_title;
        $this->metadescriptions = $video->video_description;
        if (isset($video->meta_keywords) && $video->meta_keywords)
            $this->metakeywords = $video->meta_keywords;
        if (isset($video->meta_description) && $video->meta_description)
            $this->metadescriptions = $video->meta_description;
        //
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('video', 'video') => Yii::app()->createUrl('/media/video/all'),
            $cat->cat_name => Yii::app()->createUrl('/media/video/category', array('id' => $cat->cat_id, 'alias' => $cat->alias)),
        );
        $time = time();
        Yii::app()->clientScript->registerScript('vidsta', ''
                . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: none; with: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Yii::app()->createUrl('/media/video/viewed', array('id' => $id, 'time' => $time, 'key' => ClaGenerate::encrypPassword($id . $time))) . '\" />");},1000);})'
        );
        //
        $this->render('detail', array(
            'video' => $video,
        ));
    }

    /**
     * Update viewed video
     */
    function actionViewed($id) {
        $time = Yii::app()->request->getParam('time');
        $key = Yii::app()->request->getParam('key');
        if ($key != ClaGenerate::encrypPassword($id . $time)) {
            $this->sendResponse(400);
            Yii::app()->end();
        }
        $currentTime = time();
        if ($currentTime > $time + 120) {
            $this->sendResponse(400);
            Yii::app()->end();
        }
        $video = Videos::model()->findByPk($id);
        if (!$video) {
            $this->sendResponse(404);
        }
        if ($video->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $videoSession = isset(Yii::app()->session['viewedvideo_' . $id]) ? Yii::app()->session['viewedvideo_' . $id] : false;
        if (!$videoSession) {
            $video->viewed+= (int) rand(1, 10);
            $video->save(false);
            Yii::app()->session['viewedvideo_' . $id] = $currentTime;
            echo ActiveRecord::STATUS_ACTIVED;
        }
        Yii::app()->end();
    }

    /**
     * View follow category
     */
    public function actionCategory($id) {
        $category = VideosCategories::model()->findByPk($id);

        if (!$category) {
            $this->sendResponse(404);
        }

        //Hỗ trợ seo
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;

        //Breadcrumbs
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/media/video/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );

        //Pagesize
        $pagesize = MediaHelper::helper()->getPageSize();
//        if (!$pagesize) {
//            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
//        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $list_video = Videos::getVideosInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //

        $totalitem = Videos::countVideosInCate($id);
        //

        $claCategory = new ClaCategory(array('create' => true, 'type' => ClaCategory::CATEGORY_VIDEO));
        $claCategory->application = 'frontend';

        $children_category = $claCategory->getSubCategory($id);

        /*Set layout - HTV*/
        $this->layoutForAction = '//layouts/video_category';
        if (isset($category) && $category['layout_action']) {
            $this->layoutForAction = '//layouts/'.$category['layout_action'];
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = '//layouts/video_category';
            }
        }
        if ($this->layoutForAction == '//layouts/video_category') {
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = $this->layout;
            }
        }
        /* Set View - HTV */
        $this->viewForAction = 'category';
        if (isset($category) && $category['view_action']) {
            $this->viewForAction = '//media/video/' . $category['view_action'];
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = 'category';
            }
        }


        $this->render($this->viewForAction , array(
            'list_album' => $list_video,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'children_category' => $children_category,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Videos the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Videos::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Videos $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'videos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
