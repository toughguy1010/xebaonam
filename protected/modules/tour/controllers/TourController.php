<?php

class TourController extends PublicController
{

    public $layout = '//layouts/tour';
    public $view_category = 'category';
    public $view_category_list = 'category_list';

    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/tour_index';
        //
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour') => Yii::app()->createUrl('/tour/tour'),
        );
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_TOUR);
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
        $this->render('index');
    }

    public function actionTourhot()
    {
        //
        $this->layoutForAction = '//layouts/tour_hot';
        //
        $this->breadcrumbs = array(
            Yii::t('tour', 'tourhot') => Yii::app()->createUrl('/tour/tour/tourhot'),
        );
        $this->render('tourhot');
    }

    /**
     * View tour detail
     */
    public function actionDetail($id)
    {
        $tour = Tour::model()->findByPk($id);
        if (isset($tour->tour_style_id) && $tour->tour_style_id) {
            $tour->tour_style_name = TourStyle::model()->findByPk($tour->tour_style_id)->name;
        }
        $tourInfo = TourInfo::model()->findByPk($id);
        $tourInfo->review = json_decode($tourInfo->review);
        //
        $this->pageTitle = $this->metakeywords = $tour->name;

        if (isset($tourInfo->meta_keywords) && $tourInfo->meta_keywords)
            $this->metakeywords = $tourInfo->meta_keywords;
        if (isset($tourInfo->meta_description) && $tourInfo->meta_description)
            $this->metadescriptions = $tourInfo->meta_description;
        if (isset($tourInfo->meta_title) && $tourInfo->meta_title)
            $this->metaTitle = $tourInfo->meta_title;

        if (!$tour->price_include || $tour->price_include == '') {
            $tour->price_include = $tour->tour_info->price_include;
        }
        if (!$tour->schedule || $tour->schedule == '') {
            $tour->schedule = $tour->tour_info->schedule;
        }
        if (!$tour->policy || $tour->policy == '') {
            $tour->policy = $tour->tour_info->policy;
        }
        $category = TourCategories::model()->findByPk($tour->tour_category_id);

        if ($category) {
            // get tour category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($tour->tour_category_id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item) {
                    continue;
                }
                $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/tour/tour/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }

        $this->render('detail', array(
            'tour' => $tour,
            'tourInfo' => $tourInfo,
            'category' => $category,
        ));
    }

    /**
     * @hungtm
     * get tour ajax
     * joytour
     */
    public
    function actionHotTourAjax()
    {
        $limit = Yii::app()->request->getParam('limit', 1);
        //
        $tours = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('tour'))
            ->where('site_id=:site_id AND status=:status AND ishot=:ishot', array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':ishot' => ActiveRecord::STATUS_ACTIVED))
            ->order('position ASC, created_time DESC')
            ->limit($limit)
            ->queryAll();
        $results = array();
        foreach ($tours as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }
        //
        $html = $this->renderPartial('ajax_tour_html', array(
            'tours' => $results,
        ), true);
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * action list category tour
     * @param type $id
     */
    public
    function actionCategory($id)
    {
        //
        $this->layoutForAction = '//layouts/tour_category';
        //
        $category = TourCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        if ($category->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        // get tour category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
        //
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/tour/tour/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $tours = Tour::getTourInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Tour::countTourInCate($id);
        //
        //Layout custom
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/tour_category';
        }
//
        $this->viewForAction = '//tour/tour/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category;
        }

        $this->render($this->viewForAction, array(
            'tours' => $tours,
            'category' => $category->attributes,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }


    /**
     * action list category tour
     * @param type $id
     */
    public
    function actionCategoryList($id)
    {
        //
        $this->layoutForAction = '//layouts/tour_category_list';
        //
        $category = TourCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        if ($category->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        // get tour category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
        //
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/tour/tour/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $tours = Tour::getTourInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Tour::countTourInCate($id);
        //
        //Layout custom
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/tour_category_list';
        }
//
        $this->viewForAction = '//economy/product/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category_list;
        }

        $this->render($this->viewForAction, array(
            'tours' => $tours,
            'category' => $category->attributes,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    function actionGroup($id)
    {
        $this->layoutForAction = '//layouts/tour_group';
        $tourGroup = TourGroups::model()->findByPk($id);
        if (!$tourGroup)
            $this->sendResponse(404);
        if ($tourGroup->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            $tourGroup->name => Yii::app()->createUrl('/tour/tour/group', array('id' => $id, 'alias' => $tourGroup->alias)),
        );
//
        $this->pageTitle = $tourGroup->name;
        $this->metakeywords = $tourGroup->name;
        $this->metadescriptions = $tourGroup->name;
        $this->metaTitle = $tourGroup->name;
        if ($tourGroup->meta_keywords)
            $this->metakeywords = $tourGroup->meta_keywords;
        if ($tourGroup->meta_description)
            $this->metadescriptions = $tourGroup->meta_description;
        if ($tourGroup->meta_title)
            $this->metaTitle = $tourGroup->meta_title;
//
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//
        $tours = TourGroups::getTourInGroup($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = TourGroups::countTourInGroup($id);
//
        $this->render('group', array(
            'group' => $tourGroup,
            'tours' => $tours,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    function actionTourStyle($id)
    {
        $this->layoutForAction = '//layouts/tour_style';
        $tourStyle = TourStyle::model()->findByPk($id);
        if (!$tourStyle)
            $this->sendResponse(404);
        if ($tourStyle->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            $tourStyle->name => Yii::app()->createUrl('/tour/tour/tourstyle', array('id' => $id, 'alias' => $tourStyle->alias)),
        );
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//
        $tours = Tour::getTourStyleByIds($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Tour::countTourStyleByIds($id);
//
        $this->render('tour_style', array(
            'tourstyle' => $tourStyle,
            'tours' => $tours,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }


}
