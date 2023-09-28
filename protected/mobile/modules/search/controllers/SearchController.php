<?php

class SearchController extends PublicController {

    public $layout = '//layouts/search';

    public function actionSearchTag() {
        $keyword = trim(Yii::app()->request->getParam(ClaSite::SEARCH_KEYWORD));
        $keyword = strip_tags($keyword);
        $site_id = Yii::app()->controller->site_id;
        if (!$keyword) {
            $keyword = '';
        }
        if ($keyword && mb_strlen($keyword) >= ClaSite::SEARCH_MIN_LENGHT) {
            $data = array();
            $totalcount = 0;
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
            $view = '';
            $type = Yii::app()->request->getParam(ClaSite::SEARCH_TYPE);
            $sitetypes = ClaSite::getSiteTypes();
            if (!isset($sitetypes[$type])) {
                $type = '';
            }
            $cat = Yii::app()->request->getParam(ClaCategory::CATEGORY_KEY);
            //
            if (!$type) {
                $type = Yii::app()->siteinfo['site_type'];
            }
            switch ($type) {
                case ClaSite::SITE_TYPE_INTRODUCE: {
                    // Ưu tiên tìm sản phẩm
                    $view = 'product';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Product::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                    // Nếu không tìm thấy sản phẩm nào thì sẽ tìm tin tức
                    if (!$totalcount) {
                        $view = 'news';
                        $data = News::SearchNews(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaSite::PAGE_VAR => $page,
                            'limit' => $pagesize,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                        $totalcount = count($data);
                        if ($totalcount || $page != 1) {
                            $totalcount = News::searchTotalCount(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                        }
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_NEWS: {
                    $view = 'news';
                    $data = News::SearchNews(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = News::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;

                case ClaSite::SITE_TYPE_ECONOMY: {
                    $view = 'product';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Product::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_EDU: {
                    $view = 'course';
                    $data = Course::SearchCourses(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Course::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_B2B: {
                    $view = 'b2b';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $sids = array();
                    foreach ($data as $product) {
                        if (!in_array($product['shop_id'], $sids)) {
                            $sids[] = $product['shop_id'];
                        }
                    }
                    $data_idshop = Shop::getShopFromProductIds($sids);
                }
                    break;
                case ClaSite::SITE_TYPE_FILE: {
                    $view = 'file';
                    $options = array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                    );
                    $data = Files::SearchFiles($options);
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Files::SearchFiles($options, true);
                    }
                }
                    break;
            }
            //
            $this->breadcrumbs = array(
                Yii::t('common', 'search') => Yii::app()->request->url,
            );
            //
            $this->render($view, array(
                'data' => $data,
                'totalitem' => $totalcount,
                'limit' => $pagesize,
                'keyword' => $keyword,
            ));
            //
        } else {
            $this->render('error', array(
                'error' => Yii::t('common', 'search_keyword_invalid'),
            ));
        }
    }

    /**
     * tìm kiếm
     */
    public function actionSearch() {
        $keyword = trim(Yii::app()->request->getParam(ClaSite::SEARCH_KEYWORD));
        $keyword = strip_tags($keyword);
        $site_id = Yii::app()->controller->site_id;
        if (!$keyword) {
            $keyword = '';
        }
        $this->pageTitle = $this->metakeywords = 'Kết quả tìm kiếm cho '.$keyword .' | ' . ClaHost::getServerHost();
        if ($keyword && mb_strlen($keyword) >= ClaSite::SEARCH_MIN_LENGHT) {
            $data = array();
            $totalcount = 0;
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
            $view = '';
            $type = Yii::app()->request->getParam(ClaSite::SEARCH_TYPE);
            $sitetypes = ClaSite::getSiteTypes();
            if (!isset($sitetypes[$type])) {
                $type = '';
            }
            $cat = Yii::app()->request->getParam(ClaCategory::CATEGORY_KEY);
            //
            if (!$type) {
                $type = Yii::app()->siteinfo['site_type'];
            }
            switch ($type) {
                case ClaSite::SITE_TYPE_INTRODUCE: {
                    if (!Yii::app()->siteinfo['search_exact']) {
                        // Ưu tiên tìm sản phẩm
                        $view = 'product';
                        $data = Product::SearchProducts(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaSite::PAGE_VAR => $page,
                            'limit' => $pagesize,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));

                        $totalcount = count($data);
                        if ($totalcount || $page != 1) {
                            $totalcount = Product::searchTotalCount(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                        }
                        // Nếu không tìm thấy sản phẩm nào thì sẽ tìm tin tức
                        if (!$totalcount) {
                            $view = 'news';
                            $data = News::SearchNews(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaSite::PAGE_VAR => $page,
                                'limit' => $pagesize,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                            $totalcount = count($data);
                            if ($totalcount || $page != 1) {
                                $totalcount = News::searchTotalCount(array(
                                    ClaSite::SEARCH_KEYWORD => $keyword,
                                    ClaCategory::CATEGORY_KEY => $cat,
                                ));
                            }
                        }
                    } else {
                        // Ưu tiên tìm sản phẩm
                        $view = 'product';
                        $data = Product::SearchProductsNormal(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaSite::PAGE_VAR => $page,
                            'limit' => $pagesize,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));

                        $totalcount = count($data);
                        if ($totalcount || $page != 1) {
                            $totalcount = Product::searchTotalCountNormal(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                        }
                        // Nếu không tìm thấy sản phẩm nào thì sẽ tìm tin tức
                        if (!$totalcount) {
                            $view = 'news';
                            $data = News::SearchNewsNormal(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaSite::PAGE_VAR => $page,
                                'limit' => $pagesize,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                            $totalcount = count($data);
                            if ($totalcount || $page != 1) {
                                $totalcount = News::searchTotalCountNormal(array(
                                    ClaSite::SEARCH_KEYWORD => $keyword,
                                    ClaCategory::CATEGORY_KEY => $cat,
                                ));
                            }
                        }
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_NEWS: {
                    $view = 'news';
                    $data = News::SearchNews(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = News::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;

                case ClaSite::SITE_TYPE_ECONOMY: {
                    $view = 'product';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Product::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_EDU: {
                    $view = 'course';
                    $data = Course::SearchCourses(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Course::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_B2B: {
                    $view = 'b2b';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $sids = array();
                    foreach ($data as $product) {
                        if (!in_array($product['shop_id'], $sids)) {
                            $sids[] = $product['shop_id'];
                        }
                    }
                    $data_idshop = Shop::getShopFromProductIds($sids);
                }
                    break;
                case ClaSite::SITE_TYPE_FILE: {
                    $view = 'file';
                    $options = array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                    );
                    $data = Files::SearchFiles($options);
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Files::SearchFiles($options, true);
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_TOUR: {
                    $view = 'tour';
                    $data = Tour::searchTours(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Tour::searchTours(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                            'countOnly' => true,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_CAR: {
                    // Ưu tiên tìm ô tô
                    $view = 'car';
                    $data = Car::getAllCar('*', array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                    ));
                    $totalcount = count($data);
                    // Nếu không tìm thấy sản phẩm nào thì sẽ tìm tin tức
                    if (!$totalcount) {
                        $view = 'news';
                        $data = News::SearchNewsNormal(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaSite::PAGE_VAR => $page,
                            'limit' => $pagesize,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                        $totalcount = count($data);
                        if ($totalcount || $page != 1) {
                            $totalcount = News::searchTotalCountNormal(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                        }
                    }
                }
                    break;
            }
            //
            $this->breadcrumbs = array(
                Yii::t('common', 'search') => Yii::app()->request->url,
            );
            $this->layoutForAction = '//layouts/search_index';

            //
            $this->render($view, array(
                'data' => $data,
                'totalitem' => $totalcount,
                'limit' => $pagesize,
                'keyword' => $keyword,
            ));
            //
        } else {
            $this->render('error', array(
                'error' => Yii::t('common', 'search_keyword_invalid'),
            ));
        }
    }

    public function actionSearchbycat() {
        $keyword = trim(Yii::app()->request->getParam(ClaSite::SEARCH_KEYWORD));
        $keyword = strip_tags($keyword);
        $site_id = Yii::app()->controller->site_id;
        if (!$keyword) {
            $keyword = '';
        }
        if ($keyword && mb_strlen($keyword) >= ClaSite::SEARCH_MIN_LENGHT) {
            $data = array();
            $totalcount = 0;
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
            $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
            $view = '';
            $type = Yii::app()->request->getParam(ClaSite::SEARCH_TYPE);
            $sitetypes = ClaSite::getSiteTypes();
            if (!isset($sitetypes[$type])) {
                $type = '';
            }
            $cat = Yii::app()->request->getParam(ClaCategory::CATEGORY_KEY);
            //
            if (!$type) {
                $type = Yii::app()->siteinfo['site_type'];
            }
            switch ($type) {
                case ClaSite::SITE_TYPE_INTRODUCE: {
                    // Ưu tiên tìm sản phẩm
                    $view = 'catandproduct';
                    $data = Product::SearchProductsbycat(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount > 0) {
                        foreach ($data as $key => $value) {
                            $count_value = count($value['products']);
                            if ($count_value == 0)
                                continue;
                            if ($count_value || $page != 1) {
                                $data[$key]['count_value'] = Product::searchTotalCount(array(
                                    ClaSite::SEARCH_KEYWORD => $keyword,
                                    ClaCategory::CATEGORY_KEY => $key,
                                ));
                            }
                        }
                    }
                    // Nếu không tìm thấy sản phẩm nào thì sẽ tìm tin tức
                    if (!$totalcount) {
                        $view = 'news';
                        $data = News::SearchNews(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaSite::PAGE_VAR => $page,
                            'limit' => $pagesize,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                        $totalcount = count($data);
                        if ($totalcount || $page != 1) {
                            $totalcount = News::searchTotalCount(array(
                                ClaSite::SEARCH_KEYWORD => $keyword,
                                ClaCategory::CATEGORY_KEY => $cat,
                            ));
                        }
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_NEWS: {
                    $view = 'news';
                    $data = News::SearchNews(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = News::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;

                case ClaSite::SITE_TYPE_ECONOMY: {
                    $view = 'catandproduct';
                    $data = Product::SearchProductsbycat(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount > 0) {
                        foreach ($data as $key => $value) {
                            $count_value = count($value['products']);
                            if ($count_value == 0)
                                continue;
                            if ($count_value || $page != 1) {
                                $data[$key]['count_value'] = Product::searchTotalCount(array(
                                    ClaSite::SEARCH_KEYWORD => $keyword,
                                    ClaCategory::CATEGORY_KEY => $key,
                                ));
                            }
                        }
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_EDU: {
                    $view = 'course';
                    $data = Course::SearchCourses(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Course::searchTotalCount(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                        ));
                    }
                }
                    break;
                case ClaSite::SITE_TYPE_B2B: {
                    $view = 'b2b';
                    $data = Product::SearchProducts(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $sids = array();
                    foreach ($data as $product) {
                        if (!in_array($product['shop_id'], $sids)) {
                            $sids[] = $product['shop_id'];
                        }
                    }
                    $data_idshop = Shop::getShopFromProductIds($sids);
                }
                    break;
                case ClaSite::SITE_TYPE_TOUR: {
                    $data = Tour::searchTours(array(
                        ClaSite::SEARCH_KEYWORD => $keyword,
                        ClaSite::PAGE_VAR => $page,
                        'limit' => $pagesize,
                        ClaCategory::CATEGORY_KEY => $cat,
                    ));
                    $totalcount = count($data);
                    if ($totalcount || $page != 1) {
                        $totalcount = Tour::searchTours(array(
                            ClaSite::SEARCH_KEYWORD => $keyword,
                            ClaCategory::CATEGORY_KEY => $cat,
                            'countOnly' => true,
                        ));
                    }
                }
                    break;
            }
            //
            $this->breadcrumbs = array(
                Yii::t('common', 'search') => Yii::app()->request->url,
            );
            //
            $this->render($view, array(
                'data' => $data,
                'totalitem' => $totalcount,
                'limit' => $pagesize,
                'keyword' => $keyword,
            ));
            //
        } else {
            $this->render('error', array(
                'error' => Yii::t('common', 'search_keyword_invalid'),
            ));
        }
    }

    /**
     * return suggest for user
     */
    function actionSuggest() {
        $keyword = Yii::app()->request->getParam(ClaSite::SEARCH_KEYWORD);
        $type = Yii::app()->request->getParam(ClaSite::SEARCH_TYPE);
        $results = array();
        if (!$type) {
            $type = ClaSite::SEARCH_INDEX_TYPE_PRODUCT;
        }
        if ($keyword) {
            $se = new FTSNormal();
            $results = $se->search($keyword, $type);
        }
        $this->jsonResponse(200, array(
            'html' => $this->renderPartial('result_' . $type, array(
                'data' => $results,
                'type' => $type,
            ), true)
        ));
    }
    function actionSearchManufacturer() {
        $keyword = Yii::app()->request->getParam('key');
        $manufacturer_id = Yii::app()->request->getParam('id');
        $data = array();
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $totalcount = Product::countProductsInManufacturerCat($manufacturer_id, $keyword);
        if (isset($keyword) && isset($manufacturer_id)) {
            $data = Product::getAllProducts(array(
                'keyword' => $keyword,
                'manufacturer_id' => $manufacturer_id,
                ClaSite::PAGE_VAR => $page,
                'limit' => $pagesize,
            ));
        }

        $this->render('manufacturer', array(
            'data' => $data,
            'totalitem' => $totalcount,
            'limit' => $pagesize,

        ));
    }

}
