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
        $this->pageTitle = $this->metakeywords = (Yii::app()->siteinfo['site_id'] == 1881) ? Yii::t('site', 'service') : Yii::t('site', 'bds_project_config') ;

        $this->render('index');
    }

    /**
     * BDS ProjectConfig detail
     * @param $id
     */
    public function actionDetail($id)
    {
//        $this->layoutForAction = '//layouts/bds_detail';
//        $this->viewForAction = '//bds/bdsProjectConfig/detail';
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

        //Layout custom
        $this->layoutForAction = '//layouts/' . $project->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/bds_detail';
        }
//
        $this->viewForAction = '//bds/bdsProjectConfig/' . $project->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = '//bds/bdsProjectConfig/detail';
        }
        $news_in_cate = News::getNewsInCategory($project['news_category_id'], array('limit' => 3));
        $this->render($this->viewForAction, array(
            'project' => $project,
            'images' => $images,
            'consultants' => $consultants,
            'news_in_cate' => $news_in_cate
        ));
    }

    //Category
    public function actionCategory($id)
    {
        $category = BdsCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //Init category
        $this->layoutForAction = '//layouts/bds_category';
        if ($category->layout_action) {
            $this->layoutForAction = '//layouts/' . $category->layout_action;
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = $this->layout;
            }
        }
        // Init meta
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;

        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;

        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;

        if ($category['image_path'] && $category['image_path']) {
            $this->addMetaTag(ClaUrl::getImageUrl($category['image_path'], $category['image_name'], array('width' => 1000, 'height' => 1000, 'full' => true)), 'og:image', null, array('property' => 'og:image'));
        }
        //
        $detailLink = Yii::app()->createAbsoluteUrl('/bds/bdsProjectConfig/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // Add link canonical
        $this->linkCanonical = $detailLink;
        //
        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PROJECT, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/bds/bdsProjectConfig/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }
        //$pagesize = NewsHelper::helper()->getPageSize();
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $options = [
            'limit' => $pagesize,
            'category_id' => $id,
            ClaSite::PAGE_VAR => $page];

        $projects = BdsProjectConfig::getProjects($options);
        $totalitem = BdsProjectConfig::getProjects($options, true);
        //
        $this->viewForAction = 'category';
        if ($category->view_action) {
            $this->viewForAction = '//news/news/' . $category->view_action;
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = $this->view_category;
            }
        }
        $this->render($this->viewForAction, array(
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'projects' => $projects,
        ));
    }

    /**
     * BdsProjectConfig detail
     * @param type $id
     */
    public function actionNewsDetail($id, $pid)
    {
//        $consultants = BdsProjectConfig::getConsultantInRel($pid);
        $project = BdsProjectConfig::model()->findByPk($pid);
        if (!$project) {
            $this->sendResponse(404);
        }
        if ($project->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
//        $images = $project->getImages();
//        $this->pageTitle = $this->metakeywords = $project->name;
        //
        $news = News::getNewsDetaial($id);
        if (!$news || $news['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($news['site_id'] != $this->site_id)
            $this->sendResponse(404);
        $this->pageTitle = $this->metakeywords = $news['news_title'];
        $this->metadescriptions = $news['news_sortdesc'];
        if (isset($news['meta_keywords']) && $news['meta_keywords'])
            $this->metakeywords = $news['meta_keywords'];
        if (isset($news['meta_description']) && $news['meta_description'])
            $this->metadescriptions = $news['meta_description'];
        if (isset($news['meta_title']) && $news['meta_title'])
            $this->metaTitle = $news['meta_title'];
        if ($news['image_path'] && $news['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $news['image_path'] . 's1000_1000/' . $news['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));

//        $detailLink = Yii::app()->createAbsoluteUrl('news/news/getNewsInfo', array('id' => $news['news_id'], 'alias' => $news['alias']));
//        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
//            ClaSite::redirect301ToUrl($detailLink);
//        }
        // add link canonical
//        $this->linkCanonical = $detailLink;
        $this->layoutForAction = '//layouts/micosite_news/' . $project->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/micosite_news/layout_microsite2';
        }
//        $this->viewForAction = '//bds/bdsProjectConfig/' . $project->view_action;
//        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
        $this->viewForAction = '//bds/bdsProjectConfig/news_detail';
//        }

        $this->render($this->viewForAction, array(
            'project' => $project,
            'news' => $news,
        ));
    }
}

?>