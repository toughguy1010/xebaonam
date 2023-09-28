<?php

class NewsController extends PublicController
{

    public $layout = '//layouts/news';
    public $view_category = 'category';
    public $m = 0;
    public $y = 0;

    /**
     * Index
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('news', 'news') => Yii::app()->createUrl('/news/news'),
        );
        //$this->render('index');
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $configs = ClaTheme::getThemeConfigFollowPos($sitetypename . '.' . $themename, Widgets::POS_CENTER);
//        $linkkey = ClaSite::getLinkKey();
//        $widgets = isset($configs[$linkkey]) ? $configs[$linkkey] : array();
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_NEWS);
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
        $this->render('index', array(//'widgets' => $widgets,
        ));
    }

    /**
     * news home
     */
    public function actionHome()
    {
        $this->breadcrumbs = array(
            Yii::t('news', 'news') => Yii::app()->createUrl('/news/news'),
        );
        $this->render('home', array());
    }

    /**
     * news home
     */
    public static function getImages($id)
    {
        $result = array();
        $news = News::model()->findByPk($id);
        if (!$news || $news['status'] == ActiveRecord::STATUS_DEACTIVED) {
            return $result;
        }
        if ($news['site_id'] != Yii::app()->controller->site_id) {
            return $result;
        }
        $result = $news->getImages();
        return $result;
    }

    /**
     * View news detail
     */
    public function actionDetail($id)
    {
        $this->layoutForAction = '//layouts/news_detail';

        $news = News::getNewsDetaial($id);
        //
        if (!$news || $news['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($news['site_id'] != $this->site_id)
            $this->sendResponse(404);
        //
        $this->pageTitle = $this->metakeywords = $news['news_title'];
        $this->metadescriptions = strip_tags($news['news_sortdesc']);
        if (isset($news['meta_keywords']) && $news['meta_keywords'])
            $this->metakeywords = $news['meta_keywords'];
        if (isset($news['meta_description']) && $news['meta_description'])
            $this->metadescriptions = $news['meta_description'];
        if (isset($news['meta_title']) && $news['meta_title'])
            $this->metaTitle = $news['meta_title'];
        if ($news['image_path'] && $news['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost()
                . $news['image_path'] . 's1000_1000/'
                . $news['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));

        //
        $detailLink = Yii::app()->createAbsoluteUrl('news/news/detail', array('id' => $news['news_id'], 'alias' => $news['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        $file = [];
        if (isset($news['file_id']) && $news['file_id']) {
            $file = Files::model()->findByPk($news['file_id']);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;

        // Get cat of news
        $category = NewsCategories::model()->findByPk($news['news_category_id']);
        if ($category) {
            // get product category
            $category['link'] = Yii::app()->createUrl('news/news/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($news['news_category_id']);

            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item) {
                    continue;
                }
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/news/news/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }
        $this->breadcrumbs[$news['news_title']] = $detailLink;
        /*Set layout - HTV*/
        $this->layoutForAction = '//layouts/news_detail';
        if (isset($category) && $category['layout_action']) {
            $this->layoutForAction = '//layouts/detail_' . $category['layout_action'];
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = '//layouts/news_detail';
            }
        }
        if ($this->layoutForAction == '//layouts/news_detail') {
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = $this->layout;
            }
        }
        /* Set View - HTV */
        $this->viewForAction = 'detail';
        if (isset($category) && $category['view_action']) {
            $this->viewForAction = '//news/news/detail_' . $category['view_action'];
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = 'detail';
            }
        }

        //
        $time = time();
        Yii::app()->clientScript->registerScript('newssta', ''
            . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: none; with: 0px; height: 0px;\" rel=\"noindex,nofollow\" src=\"' . Yii::app()->createUrl('/news/news/viewed', array('id' => $id, 'time' => $time, 'key' => ClaGenerate::encrypPassword('news' . $id . $time))) . '\" />");},300);})'
        );

        // PROCESS AFFILIATE
        // get cookie old
        $affiliate_id_cookie = Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME]->value;
        //
        $affiliate_id = Yii::app()->request->getParam('affiliate_id', 0);
        //
        if (isset($affiliate_id) && $affiliate_id && $affiliate_id != $affiliate_id_cookie) {
            $affiliate = AffiliateLink::model()->findByPk($affiliate_id);
            $url = Yii::app()->request->getPathInfo();
            $baseUrl = Yii::app()->getBaseUrl(true);
            $full_url = $baseUrl . '/' . $url;
            if ($affiliate !== NULL && $full_url == $affiliate->url) {
                if (!$affiliate->type && !$affiliate->object_id) {
                    $affiliate->type = AffiliateLink::TYPE_PRODUCT;
                    $affiliate->object_id = $id; // gán product id
                    $affiliate->save();
                }
                $cookie = new CHttpCookie(AffiliateLink::AFFILIATE_NAME, $affiliate_id);
                $cookie->expire = time() + 60 * 60 * 24 * 30; // 30 days
                Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME] = $cookie;
                //
                $click = new AffiliateClick();
                $click->user_id = $affiliate->user_id;
                $click->affiliate_id = $affiliate_id;
                $click->ipaddress = ClaUser::getClientIp();
                $click->operating_system = ClaUserAccess::getOS();
                if ($click->save()) {
                    $cookieClick = new CHttpCookie(AffiliateClick::AFFILIATE_CLICK, $click->id);
                    $cookieClick->expire = time() + 60 * 60 * 24 * 30; // 30 days
                    Yii::app()->request->cookies[AffiliateClick::AFFILIATE_CLICK] = $cookieClick;
                }
            }
        }

        $this->render($this->viewForAction, array(
                'news' => $news,
                'file' => $file,
                'category' => $category
            )
        );
    }

    /**
     * View news detail
     */
    public function actionGetNewsInfo($id)
    {
        //

        $this->layoutForAction = '//layouts/news_detail';
        //

        $news = News::getNewsDetaial($id);
        if (!$news || $news['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($news['site_id'] != $this->site_id)
            $this->sendResponse(404);
        //

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
        //

        $detailLink = Yii::app()->createAbsoluteUrl('news/news/getNewsInfo', array('id' => $news['news_id'], 'alias' => $news['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
        $category = NewsCategories::model()->findByPk($news['news_category_id']);

        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($news['news_category_id']);

            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/news/news/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }

        $time = time();
        Yii::app()->clientScript->registerScript('newssta', ''
            . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: none; with: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Yii::app()->createUrl('/news/news/viewed', array('id' => $id, 'time' => $time, 'key' => ClaGenerate::encrypPassword('news' . $id . $time))) . '\" />");},300);})'
        );

        $html = $this->renderPartial('ajax_news_info', array(
            'news' => $news,
//            'category' => $category
        ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * Lấy tin tức ajax
     */
    public function actionGetdetail()
    {
        $id = (int)Yii::app()->request->getParam('id');
        $news = News::getNewsDetaial($id);
        if (!$id) {
            $this->sendResponse(404);
        }
        $html = $this->renderPartial('ajax_news_detail', array(
            'news' => $news,
        ), true);
        $this->jsonResponse(200, array(
            'message' => 'success',
            'html' => $html,
        ));
    }

    /**
     * Lưu lại sản phẩm người dùng đã xem và tăng lượng người dùng xem sản phẩm
     */
    function actionViewed($id)
    {
        $time = Yii::app()->request->getParam('time');
        $key = Yii::app()->request->getParam('key');
        if ($key != ClaGenerate::encrypPassword('news' . $id . $time)) {
            $this->sendResponse(200); // 400 -> 200 do Search Engine Crawl no bao loi
            Yii::app()->end();
        }
        $currentTime = time();
        if ($currentTime > $time + 10 * 60) {
            $this->sendResponse(200); // 400 -> 2000
            Yii::app()->end();
        }
        $news = News::model()->findByPk($id);
        if (!$news)
            $this->sendResponse(404);
        if ($news->site_id != $this->site_id)
            $this->sendResponse(404);
        $viewNewsSession = Yii::app()->user->getState('viewNewsSession');
        $viewNewsSession = ($viewNewsSession) ? $viewNewsSession : array();
        if (!isset($viewNewsSession[$id])) {
            $viewNewsSession[$id] = $news['news_title'];
            Yii::app()->user->setState('viewNewsSession', $viewNewsSession);
            $news->viewed += 1;
            $news->save(false);
        }
        Yii::app()->end();
    }

    /**
     * @hungtm
     * get news ajax
     * joytour
     */
    public function actionCategoryAjax()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $limit = Yii::app()->request->getParam('limit', 1);
        //
        $category = NewsCategories::model()->findByPk($id);

        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listnews = News::getNewsInCategory($id, array(
            'limit' => $limit,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        //
        $html = $this->renderPartial('ajax_news_html', array(
            'listnews' => $listnews,
        ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * View follow category
     */
    public function actionCategory($id)
    {
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
        $category = NewsCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->layoutForAction = '//layouts/news_category';
        if ($category->layout_action) {
            $this->layoutForAction = '//layouts/' . $category->layout_action;
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = $this->layout;
            }
        }
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
        //
        $detailLink = Yii::app()->createAbsoluteUrl('news/news/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
        //
        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/news/news/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }
        //
        if (isset($category['limit']) && $category['limit'] > 0) {
            $pagesize = $category['limit'];
        } else {
            $pagesize = NewsHelper::helper()->getPageSize();
        }
//        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listnews = News::getNewsInCategory($id, array(
            'm' => $this->m,
            'y' => $this->y,
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $hotnews = News::getNewsInCategory($id, array(
            'news_hot' => 1,
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = News::countNewsInCate($id, array(
            'm' => $this->m,
            'y' => $this->y,
        ));
        //
        $month = News::getMonthNews();
        $years = News::getYearsNews();

        $this->viewForAction = 'category';
        if ($category->view_action) {
            $this->viewForAction = '//news/news/' . $category->view_action;
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = $this->view_category;
            }
        }
        if ($category['image_path'] && $category['image_path']) {
            $this->addMetaTag(ClaUrl::getImageUrl($category['image_path'], $category['image_name'], array('width' => 1000, 'height' => 1000, 'full' => true)), 'og:image', null, array('property' => 'og:image'));
        }

        $this->render($this->viewForAction, array(
            'month' => $month,
            'years' => $years,
            'listnews' => $listnews,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'hotnews' => $hotnews,
        ));
    }

    /**
     * @hatv
     * get list product ajax loader with category_id
     * marcom
     */
    public function actionAjaxLoaderCategory($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR, $offset);
            ///
            $news = News::getNewsInCategory($id, array(
                'limit' => $limit,
                ClaSite::PAGE_VAR => $page,
            ));
            $items = array();
            $lazyload_html_view = '//news/news/ajax_lazyload_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_html';
            }
            foreach ($news as $new) {
                $html = array();
                $html['html'] = $this->renderPartial($lazyload_html_view, array(
                    'new' => $new,
                ), true);
                $items[] = $html;
            }

            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

    /*
     * author: Viet
     * get group news for Product
     * $param $option
     */

    public function actionGroupNewsInProduct($option = array())
    {

        $product_id = Yii::app()->request->getParam('id', 0);
        $listnews = ProductNewsRelation::getGroupNewsInProduct($product_id);
        $totalitem = ProductNewsRelation::countNewsInManual($product_id);

        $option = 'Hướng dẫn sử dụng';
        $this->breadcrumbs = array(
            $option => Yii::app()->createUrl('/news/news/groupnewsinproduct'),
        );

        if (!$listnews) {
            $this->sendResponse(404);
        }
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);

        $this->layoutForAction = '//layouts/news';

        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }

        $this->render('category_relation', array(
            'listnews' => $listnews,
            'limit' => $pagesize,
            'totalitem' => $totalitem
        ));
    }

    /*
     * Tin liên quan
     * author: Viet
     * get group news for News Relation
     * $param $option
     */

    public function actionGroupNewsRelation($option = array())
    {
        $product_id = Yii::app()->request->getParam('id', 0);
        $listnews = ProductNewsRelation::getGroupNewsRelation($product_id);

        $totalitem = ProductNewsRelation::countNewsRelation($product_id);

        $option = 'Tin liên quan';
        $this->breadcrumbs = array(
            $option => Yii::app()->createUrl('/news/news/groupnewsrelation'),
        );
        $this->pageTitle = $this->metakeywords = 'Tin liên quan';

        if (!$listnews) {
            $this->sendResponse(404);
        }
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);

        $this->layoutForAction = '//layouts/news';

        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }

        $this->render('category_relation', array(
            'listnews' => $listnews,
            'limit' => $pagesize,
            'totalitem' => $totalitem
        ));
    }

    public function actionGroupNewsHot($option = array())
    {
        $this->layoutForAction = '//layouts/news';
        $listnews = News::getHotNews($option);
        if (!$listnews) {
            $this->sendResponse(404);
        }
        //breadcrum
        $this->breadcrumbs = array(
            Yii::t('news', 'news_group_hot') => Yii::app()->createUrl('/news/news/groupnewshot'),
        );
        //phân trang
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $totalitem = count($listnews);
        $this->render('group_news_hot', array(
            'listnews' => $listnews,
            'limit' => $pagesize,
            'totalitem' => $totalitem
        ));
    }

}
