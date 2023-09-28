<?php

class ProductController extends PublicController
{

    public $layout = '//layouts/product';
    public $view_category = 'category';
    public $view_category_level_one = 'category_level_one';
    public $total_votes;
    public $m = 0;
    public $y = 0;
    public $total_rating;
    public $itemslimit = 8;

    /**
     * product index
     */
    public function actionIndex()
    {
        $this->layoutForAction = '//layouts/product_index';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
        );
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_PRODUCT);
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

    /**
     * product index
     */
    public function actionHotdeal()
    {
//
        $this->layoutForAction = '//layouts/hotdeal';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'hotdeal') => Yii::app()->createUrl('/economy/hotdeal'),
        );
        $this->render('hotdeal');
    }

    /**
     * product index
     */
    public function actionMembersProduct()
    {
//
        $this->layoutForAction = '//layouts/product_member';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'product_member') => Yii::app()->createUrl('/economy/product/membersProduct'),
        );
        $this->render('members_product');
    }

    /**
     * Event category
     * @param type $id
     */
    public function actionPromotionCategory($id)
    {
        $this->layoutForAction = '//layouts/promotion_category';
        $category = PromotionCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
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
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/promotioncategories', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listpromotions = Promotions::getPromotionInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Promotions::getPromotionInCategory($id, '', true);
        //
        //format date_time
        //get_cat_name
        $this->render('promotion_category', array(
            'listpromotions' => $listpromotions,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * Cho thuê đò
     */
    public function actionRentProduct()
    {
//
        $this->layoutForAction = '//layouts/rent';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );

        $aryGroup = ProductRent::getProductGroupAndProduct();
        $this->render('rent', array(
            'data' => $aryGroup,
        ));
    }

    /**
     * Cho thuê đò
     */
    public function actionRentProductDetail($id = false)
    {
        $active_id = '';
        if (isset($id)) {
            $active_id = $id;
        };
        $this->layoutForAction = '//layouts/rent';
        $this->breadcrumbs = array(
            Yii::t('product', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );

        $aryGroup = ProductRent::getProductGroupAndProduct();
        $this->render('rent_detail', array(
            'data' => $aryGroup,
            'active_id' => $active_id,
        ));
    }

    // Hàm thay đổi url của các thẻ a trong nội dung html
    function replaceUrl($html, $otherVars)
    {
//        Yii::import('common.classs.Functions', true);
        set_time_limit(0);
        $reg = '%<a\s*?(.*?)href\s*?=\s*?(["\']){1}(.*?)(["\']){1}(.*?)>%';
        $callback = function ($matches) use ($otherVars) {
            return $this->replace_callback($matches, $otherVars);
        };

        $html = preg_replace_callback($reg . 'is', $callback, $html);  // _click là một function để encode url
        return $html;
    }

    public function replace_callback($matches, $otherVars = array())
    {
        $url = $matches[3];
        if ($url && (strpos($url, 'http') === false)) {
            $url = $otherVars['scheme'] . '://' . $otherVars['host'] . '/' . $url;
        }
        return '<a ' . $matches[1] . 'href=' . $matches[2] . Yii::app()->createAbsoluteUrl('economy/product/iframecraw', array('link' => urlencode($url))) . $matches[4] . $matches[5] . ' >';
    }

    public function actionIframecraw()
    {
        Yii::app()->end();
        $link = Yii::app()->request->getParam('link');
        if (!$link) {
            $link = 'nanoweb.vn';
        } else {
            $link = urldecode($link);
            $parse_url = parse_url($link);
            $scheme = $parse_url['scheme'];
            $host = $parse_url['host'];
        }
        $this->layoutForAction = false;
        if ($link) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $link);
            $homepage = trim(curl_exec($ch));
            $homepage = str_replace('_blank', '', $homepage);
            if (!$homepage) {
                $homepage = @file_get_contents($link);
            }
            if ($homepage) {
                $homepage = $this->replaceUrl($homepage, array('scheme' => $scheme, 'host' => $host));
                echo $homepage;
            }
        }
        Yii::app()->end();
    }

    public function actionNewproduct()
    {
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
//
        $this->layoutForAction = '//layouts/product_new';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'isnew') => Yii::app()->createUrl('/economy/product/newproduct'),
        );
        $this->pageTitle = Yii::t('product', 'isnew');

        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'isnew' => 1,
        ), $this->m, $this->y);
        $month = Product::getMonthProducts(array(
            'isnew' => 1,
        ));
        $years = Product::getMonthProducts(array(
            'isnew' => 1,
        ));
        $totalitem = Product::countAll(array(
            'isnew' => 1,
        ), $this->m, $this->y);

        $this->render('newproduct', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'month' => $month,
            'years' => $years,
        ));
    }

    /**
     * The page get hot products with paginate
     * @author: Hatv
     */
    public function actionHotproduct()
    {
        // Init variable
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
        $this->layoutForAction = '//layouts/product_hot';
        $this->breadcrumbs = array(
            Yii::t('product', 'ishot') => Yii::app()->createUrl('/economy/product/hotproduct'),
        );
        $this->pageTitle = Yii::t('product', 'product_ishot');
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        // Query
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'ishot' => 1,
            'select_all' => true
        ), $this->m, $this->y);
        $month = Product::getMonthProducts(array(
            'ishot' => 1,
        ));
        $years = Product::getYearsProducts(array(
            'ishot' => 1,
        ));
        $totalitem = Product::countAll(array(
            'ishot' => 1,
        ), $this->m, $this->y);
        $this->render('hotproduct', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'month' => $month,
            'years' => $years,
        ));
    }

    public function actionSalesproduct()
    {
        // Init variable
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
        $this->layoutForAction = '//layouts/product_hot';
        $this->breadcrumbs = array(
            Yii::t('product', 'issale') => Yii::app()->createUrl('/economy/product/salesproduct'),
        );
        $this->pageTitle = Yii::t('product', 'product_issale');
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        // Query
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'issale' => 1,
            'select_all' => true
        ), $this->m, $this->y);
        $month = Product::getMonthProducts(array(
            'issale' => 1,
        ));
        $years = Product::getYearsProducts(array(
            'issale' => 1,
        ));
        $totalitem = Product::countAll(array(
            'issale' => 1,
        ), $this->m, $this->y);
        $this->render('salesproduct', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'month' => $month,
            'years' => $years,
        ));
    }

    public function actionPriceDay()
    {
        // Init variable
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
        $this->layoutForAction = '//layouts/product_hot';
        $this->breadcrumbs = array(
            Yii::t('product', 'priceday') => Yii::app()->createUrl('/economy/product/priceday'),
        );
        $this->pageTitle = Yii::t('product', 'product_price_day');
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        // Query
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'ispriceday' => 1,
            'select_all' => true
        ), $this->m, $this->y);
        $month = Product::getMonthProducts(array(
            'ispriceday' => 1,
        ));
        $totalitem = Product::countAll(array(
            'ispriceday' => 1,
        ), $this->m, $this->y);
        $this->render('priceday_product', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'month' => $month,
        ));
    }

    public function actionProductWaitting()
    {
        // Init variable
        $this->m = Yii::app()->request->getParam('m', 0); //get month
        $this->y = Yii::app()->request->getParam('y', 0); //get year
        $this->layoutForAction = '//layouts/product_hot';
        $this->breadcrumbs = array(
            Yii::t('product', 'waitting_product') => Yii::app()->createUrl('/economy/product/productwaitting'),
        );
        $this->pageTitle = Yii::t('product', 'waitting_product');
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        // Query
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'iswaitting' => 1,
            'select_all' => true
        ), $this->m, $this->y);
        $month = Product::getMonthProducts(array(
            'iswaitting' => 1,
        ));
        $totalitem = Product::countAll(array(
            'iswaitting' => 1,
        ), $this->m, $this->y);
        $this->render('waitting_product', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'month' => $month,
        ));
    }

    public function actionSaleproduct()
    {
//
        $this->layoutForAction = '//layouts/product_sale';
//
        $this->breadcrumbs = array(
            Yii::t('product', 'promotion_product') => Yii::app()->createUrl('/economy/product/saleproduct'),
        );
        $this->pageTitle = Yii::t('product', 'promotion_product');

        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        $products = Product::getAllProducts(array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'sale' => 1
        ));
        $totalitem = Product::countAll(array(
            'sale' => 1,
        ));

        $this->render('saleproduct', array(
            'products' => $products,
            'limit' => $pagesize,
            'totalitem' => $totalitem
        ));
    }

    /**
     * product home
     */
    public function actionHome()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product/home'),
        );
        $this->render('home');
    }

    /**
     * Product detail
     * @param type $id
     */
    public function actionDetail($id)
    {
        //
        $this->layoutForAction = '//layouts/product_detail';
        //
        $product = Product::model()->findByPk($id);


        // check product in store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            //
            $store_product_id = (isset($product['store_ids']) && $product['store_ids']) ? explode(' ', $product['store_ids']) : array();
            if (!in_array($store_id, $store_product_id)) {
                $this->sendResponse(404);
            }
        }

        if (!$product)
            $this->sendResponse(404);
        if ($product->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if (!$product->product_desc || $product->product_desc == '')
            $product->product_desc = $product->product_info->product_desc;
        if (!$product->product_note || $product->product_note == '')
            $product->product_note = $product->product_info->product_note;
        if (!$product->product_sortdesc || $product->product_sortdesc == '')
            $product->product_sortdesc = $product->product_info->product_sortdesc;
        if (!$product->total_votes || $product->total_votes == '')
            $product->total_votes = $product->product_info->total_votes;
        if (!$product->total_rating || $product->total_rating == '')
            $product->total_rating = $product->product_info->total_rating;
        //
        $detailLink = Yii::app()->createAbsoluteUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // Link chuyen trang de lien ket cho trang chi tieet san pham
        if (isset($product->url_redirect) && $product->url_redirect) {
            ClaSite::redirect301ToUrl($product->url_redirect);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
        //
        $this->pageTitle = $this->metakeywords = $product->name;
        $this->metadescriptions = $product->product_sortdesc;
        if (isset($product->product_info->meta_keywords))
            $this->metakeywords = $product->product_info->meta_keywords;
        if (isset($product->product_info->meta_description))
            $this->metadescriptions = $product->product_info->meta_description;
        if ($product->product_info->meta_title)
            $this->metaTitle = $product->product_info->meta_title;
        if ($product['avatar_path'] && $product['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $product['avatar_path'] . 's1000_1000/' . $product['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = ProductCategories::model()->findByPk($product->product_category_id);
        // hiển thị thêm các thuộc tính hệ thống
        $attributesShow = FilterHelper::helper()->getAttributesSystemFilter(array('isArray' => true));
        if (is_null($attributesShow)) {
            $attributesShow = array();
        }

        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($product->product_category_id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
            $attributesShowInSet = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
            $attributesShow = ClaArray::AddArrayToEnd($attributesShow, $attributesShowInSet);
        }
        $link = Yii::app()->createUrl('/economy/product/detail', array('id' => $id, 'alias' => $product->alias));

        //
        $time = time();
        Yii::app()->clientScript->registerScript('prosta', ''
            . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: none; with: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Yii::app()->createUrl('/economy/product/viewed', array('id' => $id, 'time' => $time, 'key' => ClaGenerate::encrypPassword($id . $time))) . '\" />");},300);})'
        );
        //
        //Check if use module 360
        //
        $images_panorama = array();
        $options_360 = array();
        if (isset(Yii::app()->siteinfo['products_360_module']) && Yii::app()->siteinfo['products_360_module'] == 1) {
            $panorama_options = Product::getPanoramaOptions($product->id);
            $images_panorama = Product::getImagesPanorama($product->id);
            if (count($panorama_options) && count($images_panorama)) {
                foreach ($panorama_options as $k => $opi) {
                    $panorama_options[$k]['count'] = 0;
                    foreach ($images_panorama as $i => $img) {
                        if ($img['option_id'] == $opi['id'] && $img['is_default'] == 1) {
                            $panorama_options[$k]['default'] = $img;
                            unset($images_panorama[$i]);
                        }
                        if ($img['option_id'] == $opi['id']) {
                            $panorama_options[$k]['count']++;
                        }
                    }
                }
            }
            foreach ($panorama_options as $option) {
                if ($option['type'] == ActiveRecord::OPTION_PRODUCT_360) {
                    $options_360[] = $option;
                }
            }
        }
        //END 360
        //Product relation  vs news rel
        //Lấy ra 10 sản phẩm liên quan
        $products_rel = array();
        $product_videos_rel = VideosProductRel::getVideosInRel($id);
        $products_vt = array();
        $products_ink = array();
        $news_rel = array();
        $news_manual = array();
        $img_highlights=array();
        if (Yii::app()->siteinfo['related_products_module'] == 1) {
            //Sản phẩm liên quán
            $products_rel_limit = 20;
            $products_rel = ProductRelation::getProductInRel($id, array(
                'limit' => $products_rel_limit,
            ));
            $products_vt = ProductVtRelation::getProductInVtRel($id, array(
                'limit' => $products_rel_limit,
            ));
            $products_ink = ProductInkRelation::getProductInInkRel($id, array(
                'limit' => $products_rel_limit,
            ));
            //Tin tức liên quan
            $news_rel_limit = 10;
            $news_rel = ProductNewsRelation::getNewsInRel($id, array(
                'limit' => $news_rel_limit,
            ));
            /*
             * Hướng dẫn sử dụng
             */
            $news_manual = ProductNewsRelation::getNewsForProduct($id, array(
                'limit' => $products_rel_limit,
            ));
        }
        if (Yii::app()->siteinfo['product_highlights'] == 1) {
            $img_highlights=ProductImagesHightLights::getAllImageHighlight($id);
        }


        /* Set layout - HTV */
//        if ($product['product_category_id']) {
//            $this->layoutForAction = '//layouts/news_detail_' . $product['product_category_id'];
//            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
//                $this->layoutForAction = '//layouts/news_detail';
//            }
//        }
//        if ($this->layoutForAction == '//layouts/news_detail') {
//            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
//                $this->layoutForAction = $this->layout;
//            }
//        }
        /* Set View - HTV */
        $this->viewForAction = 'detail';
        if (isset($category) && $category['view_action']) {
            $this->viewForAction = '//economy/product/detail_' . $category['view_action'];
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = 'detail';
            }
        }
        // Layout thừa kế từ category nếu có sẽ được ưu tiên trước
        if (isset($category) && $category['layout_action']) {
            if (($layoutFile = $this->getLayoutFile('//layouts/detail_' . $category['layout_action'])) !== false) {
                $this->layoutForAction = '//layouts/detail_' . $category['layout_action'];
            }
        }

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
        if (isset(Yii::app()->siteinfo['site_watermark']) && Yii::app()->siteinfo['site_watermark']) {
            if ($product->avatar_wt_path == "" && $product->avatar_wt_name == "" && $product['unmarked'] == 0) {
                $model = Product::model()->findByPk($id);
                $pr = Product::addWatermark($product);
                $model->avatar_wt_path = $pr->avatar_wt_path;
                $model->avatar_wt_name = $pr->avatar_wt_name;
                $model->save();
            }
        }
        $product_rel_track = ProductVtRelation::getIdInRel($id);
        // AND AFFILIATE
        $this->render($this->viewForAction, array(
            'model' => $product,
            'product' => $product->attributes + array('product_note' => $product->product_info->product_note, 'price_text' => Product::getPriceText($product->attributes), 'price_market_text' => Product::getPriceText($product->attributes, 'price_market'), 'price_save_text' => Product::getPriceText($product->attributes, 'price_save'), 'total_rating' => $product->total_rating, 'total_votes' => $product->total_votes),
            'category' => $category,
            'attributesShow' => $attributesShow,
            'link' => $link,
            'products_rel' => $products_rel,
            'products_vt' => $products_vt,
            'products_ink' => $products_ink,
            'news_rel' => $news_rel,
            'news_manual' => $news_manual,
            'images_panorama' => $images_panorama,
            'options_360' => $options_360,
            'product_videos_rel' => $product_videos_rel,
            'img_highlights' =>$img_highlights,
            'product_rel_track' =>$product_rel_track,
        ));
    }

//

    /**
     * Compare product Suzika
     * @param type $id
     */
    public function actionCompare($id = false, $id1 = false, $id2 = false)
    {
        $this->layoutForAction = '//layouts/product_compare';
//
        $arr_prd = array();
        if ($id && $id != null) {
            $arr_prd[] = $id;
        }
        if ($id1 && $id1 != null) {
            $arr_prd[] = $id1;
        }
        if ($id2 && $id2 != null) {
            $arr_prd[] = $id2;
        }

        $products = Product::model()->findAllByPk($arr_prd);
        //check value
        if (count($products) > 1) {
            $arr_product = array_map(array($this, 'checkPrdArray'), $products);
            if (($key = array_search('', $arr_product)) !== false) {
                unset($arr_product[$key]);
            }
            $compare = array();
            $compare_att = array();
            foreach ($arr_product as $key => $product) {
                $compare = array_merge_recursive($compare, $product->attributes);
                if (isset($product->prd_att) && $product->prd_att != null) {
                    $compare_att = array_merge_recursive($compare_att, $product->prd_att);
                }
            }
            $this->pageTitle = $this->metakeywords = 'So sánh sản phẩm';

            $this->render('compare', array(
                'arr_product' => $arr_product,
                'compare_att' => $compare_att,
                'model' => $compare,
                'product' => $products->attributes,
//                'category' => $category,
                'compare' => $compare,
//                'attributesShow' => $attributesShow,
            ));
        } else {
            $product = $products[0];
            $attributesShow = null;
            $category = ProductCategories::model()->findByPk($product->product_category_id);
            if ($category) {
// get product category
                $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
                $categoryClass->application = 'public';
                $track = $categoryClass->saveTrack($product->product_category_id);
                $track = array_reverse($track);
                foreach ($track as $tr) {
                    $item = $categoryClass->getItem($tr);
                    if (!$item)
                        continue;
                    $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
                }
//
                $attributesShow = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
            }
            Yii::app()->clientScript->registerScript('prosta', ''
                . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: none; with: 0px; height: 0px;\" rel=\"nofollow\" src=\"' . Yii::app()->createUrl('/economy/product/viewed', array('id' => $id)) . '\" />");},300);})'
            );
            $this->pageTitle = $this->metakeywords = 'So sánh sản phẩm';
            $this->render('compare_single', array(
                'model' => $products[0],
                'product' => $products[0]->attributes,
                'category' => $category,
//                'compare' => $compare,
                'attributesShow' => $attributesShow,
            ));
        }
    }

    public function checkPrdArray($product)
    {
        if (!$product) {
            return FALSE;
        }
        if ($product->site_id != $this->site_id) {
            return FALSE;
        }
        if (!$product->product_desc || $product->product_desc == '')
            $product->product_desc = $product->product_info->product_desc;
        if (!$product->product_sortdesc || $product->product_sortdesc == '')
            $product->product_sortdesc = $product->product_info->product_sortdesc;
        $category = ProductCategories::model()->findByPk($product->product_category_id);
        if ($category) {
// get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($product->product_category_id);
            $track = array_reverse($track);
//
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
//
            $attributesShow = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
        }
        if ($attributesShow && count($attributesShow)) {
            $att = array();
            $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($product, $attributesShow);
            foreach ($attributesDynamic as $key => $item) {
                if (is_array($item['value']) && count($item['value'])) {
                    $item['value'] = implode(", ", $item['value']);
                }
                if ($item['value']) {
                    $att += array($item['name'] => $item["value"]);
                }
            }
            $product->prd_att = $att;
        }
        return $product;
    }

    /**
     * View này trả về data cho quickview
     * @author hungtm
     * @param type $id
     */
    public function actionQuickview()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $product = Product::model()->findByPk($id);
        if (!$product) {
            $this->sendResponse(404);
        }
        if ($product->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        if (!$product->product_sortdesc || $product->product_sortdesc == '') {
            $product->product_sortdesc = $product->product_info->product_sortdesc;
        }
        $all_price = array('price_text' => Product::getPriceText($product->attributes), 'price_market_text' => Product::getPriceText($product->attributes, 'price_market'), 'price_save_text' => Product::getPriceText($product->attributes, 'price_save'));
        $link = Yii::app()->createUrl('/economy/product/detail', array('id' => $id, 'alias' => $product->alias));

        $html = $this->renderPartial('ajax_quickview_html', array(
            'model' => $product,
            'product' => $product->attributes + array('price_text' => Product::getPriceText($product->attributes), 'price_market_text' => Product::getPriceText($product->attributes, 'price_market')),
            'link' => $link,
        ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * @hungtm
     * get product ajax
     * joytour
     */
    public function actionCategoryAjax()
    {
        $id = Yii::app()->request->getParam('id');
        $isHot = Yii::app()->request->getParam('is_hot');
        $limit = Yii::app()->request->getParam('limit');
        $first = 1;
        if (Yii::app()->request->getParam('first')) {
            $first = 0;
        }
        $category = ProductCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        if ($category->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        // get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
//
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = FilterHelper::helper()->buildFilterWhere($category->attribute_set_id);
        if (!$where)
            $where = '';
        // Check ishot
        if (!$isHot)
            $isHot = false;
//
        $products = Product::getProductsInCate($id, array(
            'limit' => $limit,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
            'onlyisHot' => $isHot,
        ));

        $html = $this->renderPartial('ajax_product_html', array(
            'products' => $products,
            'category' => $category,
            'first' => $first,
        ), true);
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * Product info
     * @param type $id
     */
    public function actionGetproductinfo($id)
    {
//
        if (Yii::app()->request->isAjaxRequest) {
//
            $product = Product::model()->findByPk($id);
            if (!$product)
                $this->jsonResponse(404);
            if ($product->site_id != $this->site_id)
                $this->jsonResponse(404);
//
            if (!$product->product_desc || $product->product_desc == '')
                $product->product_desc = $product->product_info->product_desc;
            if (!$product->product_sortdesc || $product->product_sortdesc == '')
                $product->product_sortdesc = $product->product_info->product_sortdesc;
//
            $category = ProductCategories::model()->findByPk($product->product_category_id);
            $attributesShow = null;
            if ($category) {
//
                $attributesShow = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
            }
            $link = Yii::app()->createUrl('/economy/product/detail', array('id' => $id, 'alias' => $product->alias));
//
            Yii::app()->clientScript->registerScript('prosta', ''
                . 'jQuery(document).ready(function(){ setTimeout(function(){$("body").append("<img style=\"display: block; with: 0px; height: 0px;\" src=\"' . Yii::app()->createUrl('/economy/product/viewed', array('id' => $id)) . '\" />");},300);})'
            );
//
            $html = $this->renderPartial('ajax-product-info', array(
                'model' => $product,
                'product' => $product->attributes + array('price_text' => Product::getPriceText($product->attributes), 'price_market_text' => Product::getPriceText($product->attributes, 'price_market')),
                'attributesShow' => $attributesShow,
                'link' => $link,
            ), true);

            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        }
    }

    /**
     * Product category
     * @param type $id
     */
    public function actionCategory($id)
    {
//
        $this->layoutForAction = '//layouts/product_category';
//
        $category = ProductCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(404);
        if ($category->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        if ($category['image_path'] && $category['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $category['image_path'] . 's1000_1000/' . $category['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        // check canonical link
        $detailLink = Yii::app()->createAbsoluteUrl('economy/product/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
//        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false && (Yii::app()->controller->site_id != 1142)) {
//            ClaSite::redirect301ToUrl($detailLink);
//        }
        // add link canonical
        $this->linkCanonical = $detailLink;
// get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
//
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = FilterHelper::helper()->buildFilterWhere($category->attribute_set_id);
        if (!$where)
            $where = '';
//
        $manu_id = Yii::app()->request->getParam('manu_id', '');
        $cat_multi = Yii::app()->request->getParam('cat_multi', '');
        $mnftr_id = Yii::app()->request->getParam('mnftr_id', '');
        $key_search = Yii::app()->request->getParam('key_search', '');
        $manu_model_id = Yii::app()->request->getParam('manu_model_id', '');
        $manu_type_id = Yii::app()->request->getParam('manu_type_id', '');
        $price_ab = Yii::app()->request->getParam('price_ab', '');
        $weight_ab = Yii::app()->request->getParam('weight_ab', '');
        $manuIds = $manu_id;
        if (isset($manu_model_id) && $manu_model_id) {
            $manuIds = $manu_model_id;
        }
        if (isset($manu_type_id) && $manu_type_id) {
            $manuIds = $manu_type_id;
        }
        $totalitem_all = Product::countProductsInCate($id);
        $product_all_cat = Product::getProductsInCate($id, array(
            'limit' => $totalitem_all,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
        ));

        $w = [];
        $p = [];
        foreach ($product_all_cat as $key => $value) {
            array_push($w, $value['weight']);
            array_push($p, $value['price']);
            $weight = array_unique($w);
            $price_abs = array_unique($p);
        }
        $products = Product::getProductsInCate($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
            'manu_id' => $manuIds,
            'price_ab' => $price_ab,
            'weight_ab' => $weight_ab,
            'key_search' => $key_search,
            'mnftr_id' => $mnftr_id,
            'cat_multi' => $cat_multi,
        ));
//Layout custom
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/product_category';
        }
//
        $this->viewForAction = '//economy/product/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category;
        }
//
        $totalitem = Product::countProductsInCate($id, $where, [
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
            'manu_id' => $manuIds,
            'price_ab' => $price_ab,
            'weight_ab' => $weight_ab,
            'key_search' => $key_search,
            'mnftr_id' => $mnftr_id,
            'cat_multi' => $cat_multi,
        ]);
//
        // PROCESS AFFILIATE
        // get cookie old
        $affiliate_id_cookie = Yii::app()->request->cookies[AffiliateLink::AFFILIATE_NAME]->value;
        $click_id_cookie = Yii::app()->request->cookies[AffiliateClick::AFFILIATE_CLICK]->value;
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
                    $affiliate->type = AffiliateLink::TYPE_CATEGORY;
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
        // AND AFFILIATE

        $this->render($this->viewForAction, array(
            'products' => $products,
            'category' => $category->attributes,
            'categoryClass' => $categoryClass,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'weight' => $weight,
            'price_abs' => $price_abs,
        ));
    }

    /**
     * Bản đồ đặc sản theo tỉnh
     * @param type $id
     */
    public function actionProvince($id)
    {
        $province_id = (string)$id;
        $this->layoutForAction = '//layouts/product_province';

        $category = Province::model()->findByPk($id);

        $this->metakeywords = $this->metaTitle = $this->pageTitle = 'Đặc sản ' . $category->name;
        $this->metadescriptions = 'Đặc sản ' . $category->name;
        $this->metakeywords = 'Đặc sản ' . $category->name;
        $this->metaTitle = 'Đặc sản ' . $category->name;
        // get product category
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        $products = Product::getProductsInProvince($province_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
//                    'condition' => $where,
        ));
        //Layout custom
        $this->viewForAction = $this->view_category;
        $totalitem = Product::countProductsInProvince($id);
        $this->render($this->viewForAction, array(
            'products' => $products,
            'category' => $category->attributes,
//            'categoryClass' => $categoryClass,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    /**
     * @hatv
     * get product ajax
     * joytour
     */
    public function actionProvinceAjax()
    {
        $province_id = Yii::app()->request->getParam('province_id', 0);
        $limit = Yii::app()->request->getParam('limit', 1);
//
        $category = Province::model()->findByPk($province_id);
        if (!$category) {
            $this->sendResponse(404);
        }
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        $products = Product::getProductsInProvince($province_id, array(
            'limit' => $limit,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
        ));
        $html = $this->renderPartial('ajax_product_province_html', array(
            'products' => $products,
            'category' => $category
        ), true);
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    public function actionGroupCategory($id)
    {
        $this->layoutForAction = '//layouts/product_group_category';
        $group = ProductCategoryGroup::model()->findByPk($id);
        if (!$group) {
            $this->sendResponse(404);
        }
        if ($group->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->pageTitle = $group->name;
        $this->breadcrumbs[$group['name']] = Yii::app()->createUrl('/economy/product/groupCategory', array('id' => $group['id'], 'alias' => $group['alias']));
        $ids = explode(',', $group->ids_group);
        $categories = ProductCategories::getCategoriesByIds($ids);
        $this->render('group_category', [
            'group' => $group,
            'categories' => $categories
        ]);
    }

    public function actionGroupProvince($id)
    {
        $province_id = (string)$id;
//
        $this->layoutForAction = '//layouts/product_group_province';
//
//        $category = Province::model()->findByPk($id);
        $category = Yii::app()->db->createCommand()
            ->select('*')
            ->from('province')
            ->where('location=:location', array(':location' => $province_id))
            ->queryAll();
        if (count($category)) {
            $list_product_id = array_column($category, 'province_id');
        }

        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        $products = Product::getProductsInProvince($list_product_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
        ));
//Layout custom
        $this->viewForAction = $this->view_category;
        $totalitem = Product::countProductsInProvince($id);
        $this->render($this->viewForAction, array(
            'products' => $products,
            'category' => $category->attributes,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    /**
     * Bản đồ đặc sản site dasarta
     * Product category
     * @param type $id
     */
    public function actionMapProduct()
    {
        $this->layoutForAction = '//layouts/map_product';
//      Meta-tag
//        $this->metakeywords = $this->metaTitle = $this->pageTitle = 'Đặc sản ' . $category->name;
//        $this->metadescriptions = 'Đặc sản ' . $category->name;
//        $this->metakeywords = 'Đặc sản ' . $category->name;
//        $this->metaTitle = 'Đặc sản ' . $category->name;
//        Get all province
//
        $list_province = Yii::app()->db->createCommand()
            ->select('*')
            ->from('province')
            ->where('position!=:position', array(':position' => '0'))
            ->queryAll();
// get product category
//        $pagesize = ProductHelper::helper()->getPageSize();
//        $page = ProductHelper::helper()->getCurrentPage();
//        $order = ProductHelper::helper()->getOrderQuery();
//
//        $products = Product::getProductsInProvince($province_id, array(
//                    'limit' => $pagesize,
//                    ClaSite::PAGE_VAR => $page,
//                    'order' => $order,
//                    'condition' => $where,
//        ));
//Layout custom
//        $this->viewForAction = $this->view_category;
//        $totalitem = Product::countProductsInProvince($id, $where);
        $this->render('map_product', array(
            'list_province' => $list_province,
        ));
    }

    //Hatv -------
    //Category level 1(hatv)
    public function actionCategoryLevelOne($id)
    {
        $this->layoutForAction = '//layouts/product_category';
//        $this->viewForAction = '//category_level_one';
        $category = ProductCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(404);
        if ($category->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
        // get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
        //
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
        //
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        //Condition
        $where = FilterHelper::helper()->buildFilterWhere($category->attribute_set_id);
        if (!$where) {
            $where = '';
        }
        //Products In cate
        $child_category = new ClaCategory();
        $child_category->type = ClaCategory::CATEGORY_PRODUCT;
        $child_category->generateCategory();
        $option = $child_category->createArrayCategory($id);
        $this->category = $option;
        foreach ($option as $key => $cate) {
            $products[$key]['products'] = Product::getProductsInCate($key, array('limit' => $this->itemslimit, 'condition' => $where, 'order' => $order,));
        }
        //Layout custom
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/product_category';
        }

        $this->viewForAction = '//economy/product/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category_level_one;
        }
        $totalitem = Product::countProductsInCate($id, $where);
        $this->render($this->viewForAction, array(
            'products' => $products,
            'category' => $category->attributes,
            'child_category' => $option,
            'categoryClass' => $categoryClass,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    /**
     * Product category
     * @param type $id
     */
    public function actionCategorySearch($id)
    {
//
        $this->layoutForAction = '//layouts/product_search';
//
        $category = ProductCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(404);
        if ($category->site_id != $this->site_id)
            $this->sendResponse(404);
        $attributesShow = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id, 'is_frontend=1');
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
// get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $track = $categoryClass->saveTrack($id);
        $track = array_reverse($track);
//
        foreach ($track as $tr) {
            $item = $categoryClass->getItem($tr);
            if (!$item)
                continue;
            $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/economy/product/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
        }
//
        $pagesize = (int)Yii::app()->request->getParam('psize', 24);
        $pagesize = ($pagesize > 0) ? $pagesize : 24;
//$pagesize = 3;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//
        if ($category->attribute_set_id) {
            $where = FilterHelper::helper()->buildFilterWhere($category->attribute_set_id);
            $order = FilterHelper::helper()->buildFilterOrder();
            if (!$order) {
                $order = 'cus_field23 DESC, created_time DESC';
            }
        } else {
            $where = '';
            $order = '';
        }
        $products = Product::getProductsInCate($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'condition' => $where,
            'order' => $order,
        ));
//
        $totalitem = Product::countProductsInCate($id, $where);
//
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getBaseUrl() . '/js/site/economy/global.js');
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('category_search', array(
                'products' => $products,
                'attributesShow' => $attributesShow,
                'category' => $category->attributes,
                'totalitem' => $totalitem,
                'limit' => $pagesize,
            ));
        } else {
            $this->render('category_search', array(
                'products' => $products,
                'attributesShow' => $attributesShow,
                'category' => $category->attributes,
                'totalitem' => $totalitem,
                'limit' => $pagesize,
            ));
        }
    }

//
    public function actionAttributeSearch()
    {
        $this->layoutForAction = '//layouts/product_search';
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = FilterHelper::helper()->buildSystemFilterWhere();
//
        $options = array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
        );
//
        $products = Product::getProductsByCondition($options);
//
        $totalitem = Product::countProductsByCondition($options);
//
        $this->render('attribute_search', array(
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    public function actionAttributeSearchValue()
    {

        $this->layoutForAction = '//layouts/product_search';
        //
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
        //
        $params[ClaSite::SEARCH_KEYWORD] = strip_tags(trim(Yii::app()->request->getParam('name', '')));
        $params['code'] = strip_tags(trim(Yii::app()->request->getParam('code', '')));
        $params['product_sortdesc'] = strip_tags(trim(Yii::app()->request->getParam('product_sortdesc', '')));
        $params['product_desc'] = strip_tags(trim(Yii::app()->request->getParam('product_desc', '')));
        $params[ClaSite::PAGE_PRICE_FROM] = Yii::app()->request->getParam(ClaSite::PAGE_PRICE_FROM);
        $params[ClaSite::PAGE_PRICE_TO] = Yii::app()->request->getParam(ClaSite::PAGE_PRICE_TO);
        //

        $where = FilterHelper::helper()->buildSystemFilterWhere();
        //
        if (ClaSite::ShowModule()) {
            Yii::app()->request->getParam('name');
        }

        $options = array(
            ClaSite::SEARCH_KEYWORD => $params[ClaSite::SEARCH_KEYWORD],
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
            'params' => $params,
        );
        //
        $products = Product::SearchProductsAdvanced($options);
        $totalitem = Product::searchTotalCount($options);
        //
        $this->render('attribute_search', array(
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
            'page' => $page,
            'order' => $order,
        ));
    }

    //
    public function actionAttributeSearchForm()
    {
        $this->layoutForAction = '//layouts/product_search';
//
//        $products = new Product();
//        $productsInfo = new ProductInfo();
//        $products->unsetAttributes();
//        $productsInfo->unsetAttributes();
//
        $this->render('attribute_search_form', array(
//            'products' => $products,
//            'productsInfo' => $productsInfo,
        ));
    }

    public function actionAttributeGearSearch()
    {

        if (Yii::app()->request->isAjaxRequest) {
            $pagesize = ProductHelper::helper()->getPageSize();
            $page = ProductHelper::helper()->getCurrentPage();
            $order = ProductHelper::helper()->getOrderQuery();
            $province = $_GET['woeid'];
            $date_op = $_GET['date'];
            $json_weather = $this->apiYahooWeather($province);
            if (isset($json_weather->query->count) && $json_weather->query->count) {
                $json_weather = $json_weather->query->results->channel->item;
            }
            //Chọn mùa
            $temp_select = $json_weather->forecast[$date_op];
            $average = (int)(($temp_select->high + $temp_select->low) / 2);
            $season = Season::getSeasonsByTemp(array('temp' => $average));
            $season_id = array();
            if (count($season)) {
                $season_id = array_map(function ($product) {
                    return $product['id'];
                }, $season);
                $where = FilterHelper::helper()->buildSystemFilterWhere(array('season_id' => $season_id));
            } else {
                $where = FilterHelper::helper()->buildSystemFilterWhere();
            };
            $options = array(
                'limit' => 20,
                ClaSite::PAGE_VAR => $page,
                'order' => $order,
                'condition' => $where,
            );
            //
            $products = Product::getProductsByCondition($options);
            $totalitem = Product::countProductsByCondition($options);
            //
            Yii::import("application.modules.economy.helper.FilterHelper", true);
            $baseUrl = 'economy/product/attributeSearch';
            $options = array(
                'route' => Yii::app()->createUrl($baseUrl),
            );
            $check_attribute = array();
            $attributes = FilterHelper::helper()->getAttributesSystemOptions($options);
            if (count($attributes)) {
                foreach ($attributes as $attribute) {
                    foreach ($attribute['options'] as $key => $option) {
                        if (isset($option['checked']) && $option['checked']) {
                            $check_attribute[$attribute['att']->name] = $option['name'];
                        }
                    }
                }
            }
            // Convert JSON to PHP object
            $html = $this->renderPartial('ajax_gear_search', array('products' => $products,
                'totalitem' => $totalitem,
                'json_weather' => $json_weather,
                'temp_select' => $temp_select,
                'date_op' => $date_op,
                'province' => $province,
                'attributes' => $attributes,
                'check_attribute' => $check_attribute,
                'limit' => $pagesize,), true);

            $this->jsonResponse(200, array('html' => $html));
        }
    }

    public function apiYahooWeather($location)
    {
        $BASE_URL = "http://query.yahooapis.com/v1/public/yql";
        $yql_query = 'select item from weather.forecast where woeid =' . $location . '  AND u="c"';
        $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
        // Make call with cURL
        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $json_weather = curl_exec($session);
        return json_decode($json_weather);
    }

//
    public function actionAjaxProHover($id, $att_set_id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        $product_id = (int)Yii::app()->request->getParam('id', 0);
        $att_set_id = (int)Yii::app()->request->getParam('att_set_id', 0);
        if (!$att_set_id || !$product_id)
            Yii::app()->end();
        $product = ($product_id) ? Product::model()->findByPk($product_id) : null;
        if (!$product)
            Yii::app()->end();
        if ($product->site_id != $this->site_id)
            Yii::app()->end();

        $attributesShow = ($att_set_id) ? ProductAttributeSet::model()->getAttributesBySet($att_set_id, 'is_frontend=1') : null;
        $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($product, $attributesShow);
        if (!empty($attributesShow)) {
            foreach ($attributesShow as $key => $value) {
                $attributesShow[$key]['value'] = isset($attributesDynamic[$key]['value']) ? $attributesDynamic[$key]['value'] : '';
            }
        }
        $pro = $product->getAttributes();
        $pro['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $pro['id'], 'alias' => $pro['alias']));
        $this->renderPartial('ajax_pro_hover', array('pro' => $pro, 'attributesShow' => $attributesShow));
    }

    /**
     * Lưu lại sản phẩm người dùng đã xem và tăng lượng người dùng xem sản phẩm
     */
    function actionViewed($id)
    {
        $time = Yii::app()->request->getParam('time');
        $key = Yii::app()->request->getParam('key');
        if ($key != ClaGenerate::encrypPassword($id . $time)) {
            $this->sendResponse(200); // (loi 400) nhung tra ve 200 de google khong canh bao
            Yii::app()->end();
        }
        $currentTime = time();
        if ($currentTime > $time + 10 * 60) {
            $this->sendResponse(200);
            Yii::app()->end();
        }
        $product = Product::model()->findByPk($id);
        if (!$product)
            $this->sendResponse(200); // dung la tra ve 404
        if ($product->site_id != $this->site_id)
            $this->sendResponse(200); // dung la tra ve 404
//
        $productSession = Yii::app()->user->getState('productSession');
        $productSession = ($productSession) ? $productSession : array();
        if (!isset($productSession[$id])) {
//
            $productSession[$id] = $product['name'];
            Yii::app()->user->setState('productSession', $productSession);
            Product::setViewedProduct($id, array('id' => $id, 'alias' => $product['alias'], 'name' => $product['name'], 'price' => $product['price'], 'price_market' => $product['price_market'], 'avatar_path' => $product['avatar_path'], 'avatar_name' => $product['avatar_name']));
            $product->viewed += 1;
            $product->save(false);
//
        }
        Yii::app()->end();
    }

    /**
     * Add sản phẩm so sánh
     */
    function actionAddToCompare()
    {
        $id = Yii::app()->request->getParam('id');
        $product = Product::model()->findByPk($id);
        if (!$product)
            $this->sendResponse(404); // dung la tra ve 404
        if ($product->site_id != $this->site_id)
            $this->sendResponse(404); // dung la tra ve 404


//Check state
        $productSession = Yii::app()->user->getState('productCompare');
        $productSession = ($productSession) ? $productSession : array();
        if (isset($productSession[$id])) {
            $this->jsonResponse(300, array(
                'msg' => Yii::t('product', 'product_compare_exist')));
        }
        if (count($productSession) > 3) {
            $this->jsonResponse(300, array(
                'msg' => Yii::t('product', 'product_compate_greater_than')));
        } else {
            $productSession[$id] = $product['name'];
            Yii::app()->user->setState('productCompare', $productSession);
        }
        $first = true;
        if (count($productSession) > 1) {
            $first = false;
        }
        $html = $this->renderPartial('item_compare', array(
            'product' => $product,
            'first' => $first,
        ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
            'first' => $first));
    }

    /**
     * Xóa sản phẩm so sánh
     */
    function actionDeleteCompare($clear = false)
    {
        //clear
        if ($clear) {
            Yii::app()->user->setState('productCompare', array());
            $this->jsonResponse(200, array('html' => ''));
        }
        //Get ID
        $id = Yii::app()->request->getParam('id');
        //Check state
        $productSession = Yii::app()->user->getState('productCompare');
        $productSession = ($productSession) ? $productSession : array();
        if (isset($productSession[$id])) {
            unset($productSession[$id]);
            Yii::app()->user->setState('productCompare', $productSession);
        }
        $this->jsonResponse(200);
    }

    /**
     * @author Hatv
     * Compare product New Version
     * @param type $id
     */
    public function actionCompareProduct($option = array())
    {
        $this->layoutForAction = '//layouts/product_compare';

        $viewed_product_cookie = Yii::app()->user->getState('productCompare');
        if (isset($viewed_product_cookie) && count($viewed_product_cookie)) {

            while (current($viewed_product_cookie)) {
                $product_ids[] = key($viewed_product_cookie) . "  ";
                next($viewed_product_cookie);
            }
        }
        $attributesDynamic = [];
        $products = Product::model()->findAllByPk($product_ids);

        $attr = array();
        //check value
        if (count($products) > 1) {
            $category = ProductCategories::model()->findByPk($products[0]['product_category_id']);
            $attributesShow = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
            foreach ($products as $product) {
                if ($category) {
                    if ($attributesShow && count($attributesShow)) {
                        $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($product, $attributesShow);
                        $attr[] = $attributesDynamic;
                        foreach ($attributesDynamic as $key => $item) {
                            if (is_array($item['value']) && count($item['value'])) {
                                $item['value'] = implode(", ", $item['value']);
                            }
                            if ($item['value'])
                                echo '<tr><td>' . $item['name'] . '</td><td>' . $item["value"] . '</td>';
                        }
                    }
                }
            }
        }

        $this->pageTitle = $this->metakeywords = 'So sánh sản phẩm';
        $this->render('compare_product', array(
            'attr' => $attr,
            'products' => $products,
            'attributesShow' => $attributesShow,
            '$attributesDynamic' => $attributesDynamic,
        ));
    }

    /**
     * @author: Hatv
     * Get Brand Explorer - Get All Manufacturer
     * return array
     */
    function actionBrandExplorer()
    {
        $this->layoutForAction = '//layouts/product_manufacturer';

        $manufacturers = Manufacturer::getFullManufacturersInSite();
        $counts = Manufacturer::countProductByManufacturer();

        $data = array();
        if (count($manufacturers)) {
            $data = ClaArray::sortAryByFirstLetter($manufacturers);
            $data_upper = array_change_key_case($data, CASE_UPPER);
        }
        $this->render('brand_explorer', array(
            'data' => $data_upper,
            'number' => $counts,
        ));
    }

    function actionPromotion($id)
    {
        $this->layoutForAction = '//layouts/product_promotion';
        $promotion = Promotions::model()->findByPk($id);
        if (!$promotion)
            $this->sendResponse(404);
        if ($promotion->site_id != $this->site_id)
            $this->sendResponse(404);

        $this->breadcrumbs = array(
            $promotion->name => Yii::app()->createUrl('/economy/product/promotion', array('id' => $id, 'alias' => $promotion->alias)),
        );
//
        $this->pageTitle = $promotion->name;
        $this->metakeywords = $promotion->name;
        $this->metadescriptions = $promotion->sortdesc;
        if ($promotion->meta_keywords)
            $this->metakeywords = $promotion->meta_keywords;
        if ($promotion->meta_description)
            $this->metadescriptions = $promotion->meta_description;
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
//
        $products = Promotions::getProductInPromotion($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Promotions::countProductInPromotion($id);
//
        $this->render('promotion', array(
            'promotion' => $promotion,
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    // Trang danh mục khuyến mãi
    function actionPromotionIndex()
    {
        $this->layoutForAction = '//layouts/product_promotion_list';
        $this->breadcrumbs = array(
            Yii::t('product', 'promotion') => Yii::app()->createUrl('/economy/product/promotionIndex'),
        );
        $this->pageTitle = Yii::t('product', 'promotion');
        $this->metakeywords = Yii::t('product', 'promotion');
        $this->metadescriptions = Yii::t('product', 'promotion');
        $page = ProductHelper::helper()->getCurrentPage();
        $this->render('promotion_list', array());
    }

    /**
     * Page contain all group product
     */
    function actionGroupAll()
    {
        $this->layoutForAction = '//layouts/product_group_all';
        $productGroup = ProductGroups::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id']));
        if (!$productGroup)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            'Nhóm sản phẩm' => Yii::app()->createUrl('/economy/product/groupAll'),
        );
        // Init
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_PRODUCT_GROUP);
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
        $this->render('group_all', array(
            'groups' => $productGroup,
        ));
    }

    /**
     * sản phẩm trong nhóm
     * @param type $id
     */
    function actionGroup($id)
    {
        $this->layoutForAction = '//layouts/product_group';
        $productGroup = ProductGroups::model()->findByPk($id);
        if (!$productGroup)
            $this->sendResponse(404);
        if ($productGroup->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            $productGroup->name => Yii::app()->createUrl('/economy/product/promotion', array('id' => $id, 'alias' => $productGroup->alias)),
        );
//
        $this->pageTitle = $productGroup->name;
        $this->metakeywords = $productGroup->name;
        $this->metadescriptions = $productGroup->name;
        $this->metaTitle = $productGroup->name;
        if ($productGroup->meta_keywords)
            $this->metakeywords = $productGroup->meta_keywords;
        if ($productGroup->meta_description)
            $this->metadescriptions = $productGroup->meta_description;
        if ($productGroup->meta_title)
            $this->metaTitle = $productGroup->meta_title;
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
//
        $products = ProductGroups::getProductInGroup($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = ProductGroups::countProductInGroup($id);
//
        $this->render('group', array(
            'group' => $productGroup,
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
//breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/product/create'),
        );
        $model = new Product;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->isnew = Product::STATUS_ACTIVED;
        $model->position = Product::POSITION_DEFAULT;
        $model->state = Product::STATUS_ACTIVED;
        $productInfo = new ProductInfo;
        $productInfo->site_id = $this->site_id;
//
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
//
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->processPrice();
            if ($model->name)
                $model->alias = HtmlFormat::parseToAlias($model->name);
            if (isset($_POST['ProductInfo'])) {
                $productInfo->attributes = $_POST['ProductInfo'];
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model, $productInfo);
            }
            if (!$category->checkCatExist($model->product_category_id))
                $this->sendResponse(400);
            if ($model->validate()) {
// các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
//
                $model->category_track = $categoryTrack;
//
                if ($model->save(false)) {
                    $productInfo->product_id = $model->id;
                    $productInfo->save();
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $product_avatar = array();
//
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0)
                                        $product_avatar = $nimg->attributes;
                                    if ($imgtem->img_id == $simg_id)
                                        $product_avatar = $nimg->attributes;
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
//
// update avatar of product
                        if ($product_avatar && count($product_avatar)) {
                            $model->avatar_path = $product_avatar['path'];
                            $model->avatar_name = $product_avatar['name'];
                            $model->avatar_id = $product_avatar['img_id'];
//
                            $model->save();
                        }
                    }
// Save Manufacturer
                    if ($model->manufacturer_id) {
                        $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                        if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                            if ($manufacturer->addCategoryId($model->product_category_id))
                                $manufacturer->save();
                        }
                    }
//
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/economy/product'),
                        ));
                    } else
                        $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'category' => $category,
            'productInfo' => $productInfo,
        ));
    }

    /**
     * @hungtm
     * action like product
     */
    public function actionLikeProduct()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $check = Likes::model()->find('user_id=:user_id AND object_id=:object_id', [':user_id' => Yii::app()->user->id, 'object_id' => $id]);
        if ($check) {
            $this->jsonResponse(500);
        }
        if ($id) {
            $model = new Likes();
            $model->object_id = $id;
            $model->user_id = Yii::app()->user->id;
            $model->type = Likes::TYPE_PRODUCT;
            $model->site_id = Yii::app()->controller->site_id;
            $model->created_time = time();
            if ($model->save()) {
                $this->jsonResponse(200, array('count_like' => Likes::countLikedProduct($id, Likes::TYPE_PRODUCT)));
            } else {
                $this->jsonResponse(500);
            }
        } else {
            $this->jsonResponse(404);
        }
    }

    /**
     * @Hatv
     * action like product
     */
    public function actionUnlikeProduct()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if ($id) {
            if (Likes::model()->deleteAllByAttributes(array('object_id' => $id))) {
                $this->jsonResponse(200, array('count_like' => Likes::countLikedProduct($id, Likes::TYPE_PRODUCT)));
            }
        } else {
            $this->jsonResponse(404);
        }
    }

    /**
     * @author:Hatv
     * Show Manufacturer And Paginate
     * returnarray
     */
    public function actionListManufacturer()
    {
        $this->layoutForAction = '//layouts/manufacturer';
        $this->breadcrumbs = array(
            Yii::t('product', 'partner') => Yii::app()->createUrl('/economy/product/listManufacturer')
        );
        $this->render('list_manufacturer');
    }

    /**
     * @author:Hatv
     * Show Detail Manufacturer
     * return array
     */
    public function actionManufacturerDetail($id)
    {
        $this->layoutForAction = '//layouts/manufacturer_detail';

        $model = Manufacturer::model()->findByPk($id);
        if (!$model) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }

        $this->breadcrumbs = array(
            Yii::t('product', 'partner') => Yii::app()->createUrl('/economy/product/listManufacturer'),
            $model->name => Yii::app()->createUrl('/economy/product/listManufacturer')
        );
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 0;
        }
        //
        $this->render('manufacturer_detail', array('model' => $model,
                'pagesize' => $pagesize,
                'page' => $page)
        );
    }

    /**
     * @hungtm
     * get list product ajax loader
     * 21six
     */
    public function actionAjaxLoader()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $products = Product::getAllProducts(array(
                'limit' => $limit,
                'page' => $offset,
            ));
            $items = array();
            $lazyload_html_view = '//economy/product/ajax_lazyload_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_html';
            }
            foreach ($products as $product) {
                $html = array();

                $html['html'] = $this->renderPartial($lazyload_html_view, array(
                    'product' => $product,
                ), true);
                $items[] = $html;
            }

            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }


    public function actionAjaxLoadImageAttrColor()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product_id = Yii::app()->request->getParam('id');
            $img_id = Yii::app()->request->getParam('key');
            if ($product_id && $img_id) {
                $images = ProductImagesColor::getImagesProductColorCode($product_id,$img_id);
                $html = '';
                if (count($images)) {
                    $html = $this->renderPartial('load_image_attr', array(
                        'images' => $images,
                    ), true);
                }
                $this->jsonResponse(200, array(
                    'html' => $html,
                ));
            }

        }
    }

    /**
     * @Hatv
     * get list product ajax loader
     * suzika
     */
    public function actionAjaxLoaderHotProduct()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $products = Product::getHotProductsPager(array(
                'limit' => $limit,
                'page' => $offset,
            ));

            $items = array();
            $lazyload_html_view = '//economy/product/ajax_lazyload_hotprd_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_hotprd_html';
            }
            if (count($products)) {
                $items = $this->renderPartial($lazyload_html_view, array(
                    'products' => $products,
                ), true);
            }
            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

    /**
     * @hungtm
     */
    public function actionAjaxLoaderSale()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $products = Product::getAllProducts(array(
                'limit' => $limit,
                'page' => $offset,
                'sale' => 1
            ));
            $items = array();
            $lazyload_html_view = '//economy/product/ajax_lazyload_sale_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_sale_html';
            }
            foreach ($products as $product) {
                $html = array();

                $html['html'] = $this->renderPartial($lazyload_html_view, array(
                    'product' => $product,
                ), true);
                $items[] = $html;
            }

            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

    /**
     * @hungtm
     */
    public function actionAjaxLoaderNew()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $products = Product::getAllProducts(array(
                'limit' => $limit,
                'page' => $offset,
                'isnew' => 1
            ));
            $items = array();
            $lazyload_html_view = '//economy/product/ajax_lazyload_new_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_new_html';
            }
            foreach ($products as $product) {
                $html = array();

                $html['html'] = $this->renderPartial($lazyload_html_view, array(
                    'product' => $product,
                ), true);
                $items[] = $html;
            }

            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

    /**
     * @hungtm
     * get list product ajax loader with category_id
     * 21six
     */
    public function actionAjaxLoaderCategory($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
//            $id = Yii::app()->request->getParam('id');
            $limit = Yii::app()->request->getParam('limit');
            $offset = Yii::app()->request->getParam('offset');
            $products = Product::getProductsInCate($id, array(
                'limit' => $limit,
                ClaSite::PAGE_VAR => $offset,
            ));
            $items = array();
            $lazyload_html_view = '//economy/product/ajax_lazyload_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_lazyload_html';
            }
            foreach ($products as $product) {
                $html = array();
                $html['html'] = $this->renderPartial($lazyload_html_view, array(
                    'product' => $product,
                ), true);
                $items[] = $html;
            }

            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

    /**
     * Đánh giá sản phẩm
     */
    public function actionAddrating($id)
    {
        //submit form
        $rating_score = $_GET['ProductRating'];
        Yii::app()->user->setFlash('success', Yii::t('common', 'sendsuccess'));
        $product = Product::model()->findByPk($id);
        if ($product->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        if ($rating_score && (0 <= $rating_score['rating'] && $rating_score['rating'] > 5)) {
            $this->sendResponse(404);
        }

        $ProductRating = new ProductRating;
        $ProductRating->attributes = $rating_score;
        if (!Yii::app()->user->isGuest && isset(Yii::app()->controller->site_id) && Yii::app()->controller->site_id != null) {
            $ProductRating->name = Yii::app()->user->name;
        }
        $ProductRating->product_id = $id;
        $ProductRating->user_id = Yii::app()->user->id;
        $ProductRating->site_id = Yii::app()->controller->site_id;
        $ProductRating->type = 1;
        $ProductRating->status = 0;
        $ProductRating->created_time = time();
        if ($ProductRating->save()) {
            $this->jsonResponse(200, array('msg' => 'Cám ơn bạn đã bình luận. Quản trị viên sẽ xét duyệt hiển thị'));
        } else {
            $this->jsonResponse(400, array('msg' => 'Vui lòng điền đầy đủ thông tin.'));
        }
    }

    function actionGetproductprice($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            if ($product && $product->site_id == $this->site_id) {
                $attributes = Yii::app()->request->getParam(ClaShoppingCart::PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY);
                if ($attributes && count($attributes)) {
                    $where = 'site_id = ' . Yii::app()->controller->site_id . ' AND product_id=' . $id;
                    $params = array();
                    foreach ($attributes as $attribute_id => $configurable_value) {
                        $attr = ProductAttribute::model()->findByPk($attribute_id);
                        if ($attr->site_id != $this->site_id) {
                            continue;
                        }
                        $attrOption = AttributeHelper::helper()->getSingleAttributeOption($attribute_id, $configurable_value);
                        if (!$attrOption) {
                            continue;
                        }
                        $where .= ' AND ' . 'attribute' . $attr['field_configurable'] . '_value' . '=:' . 'attribute' . $attr['field_configurable'] . '_value';
                        $params[':' . 'attribute' . $attr['field_configurable'] . '_value'] = $configurable_value;
                    }
                    $proConfigVal = ProductConfigurableValue::model()->find($where, $params);
                    if ($proConfigVal && $proConfigVal['price']) {
                        $product->price = $proConfigVal['price'];
                    }
                }
                $this->jsonResponse(200, array(
                    'price' => HtmlFormat::money_format($product->price),
                    'priceText' => Product::getPriceText($product),
                    'priceMarket' => HtmlFormat::money_format($product->price_market),
                    'priceMarketText' => Product::getPriceText($product, 'price_market'),
                ));
            }
            $this->jsonResponse(400);
        } else {
            $this->sendResponse(400);
        }
    }

    /**
     * sản phẩm trong tag của ảnh
     * @param type $id
     */
    function actionImagetag($id)
    {
        $this->layoutForAction = '//layouts/product_image_tag';
        $productTag = ProductImagesTag::model()->findByPk($id);
        if (!$productTag)
            $this->sendResponse(404);
        if ($productTag->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            Yii::t('common', 'tag') => Yii::app()->createUrl('/economy/product/imagetag', array('id' => $id)),
        );
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
//
        $products = ProductImagesTag::getProductInTab($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = ProductImagesTag::countProductInTag($id);
//
        $this->render('image_tag', array(
            'tag' => $productTag,
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    /**
     * sản phẩm trong tag của ảnh
     * @param type $id
     */
    function actionImagetagajax()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $this->layoutForAction = '//layouts/product_image_tag';
        $productTag = ProductImagesTag::model()->findByPk($id);
        if (!$productTag)
            $this->sendResponse(404);
        if ($productTag->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array(
            Yii::t('common', 'tag') => Yii::app()->createUrl('/economy/product/imagetag', array('id' => $id)),
        );
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
//
        $products = ProductImagesTag::getProductInTab($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = ProductImagesTag::countProductInTag($id);
//
        $html = $this->renderPartial('image_tag_ajax', array(
            'tag' => $productTag,
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ), true);
        $this->jsonResponse(200, array('html' => $html));
    }


    public function actionGetdetail()
    {
        $id = (int)Yii::app()->request->getParam('id');
        if (!$id) {
            $this->sendResponse(404);
        }
        $html = $this->renderPartial('//economy/product/ajax-product-info', array(
            'id' => $id,
        ), true);
        $this->jsonResponse(200, array(
            'message' => 'success',
            'html' => $html,
        ));
    }

    /**
     * Lay cac tag cua anh
     * @param type $iid
     * @return json mang tags
     */
    function actionLoadtag()
    {
        $iid = Yii::app()->request->getParam('iid');
        $isAjax = Yii::app()->request->isAjaxRequest;
        $productImg = ProductImages::model()->findByPk($iid);
        if (!$productImg) {
            $this->jsonResponse(200, array());
        }
        if ($productImg->site_id != $this->site_id) {
            $this->jsonResponse(200, array());
        }
        $tags = ProductImagesTag::model()->findAllByAttributes(array('img_id' => $iid, 'site_id' => $this->site_id));
        $data = [];
        foreach ($tags as $index => $tag) {
            $data[$index]['info'] = json_decode($tag->data, true);
            $data[$index]['box_item'] = $this->renderPartial('image_tag_box_item', array('tag' => $tag), true);
        }
        $this->jsonResponse(200, array('data' => $data));
    }

    //

    public function actionBooking()
    {
        $this->layoutForAction = '//layouts/product_booking';
        $this->render('booking');
    }

    public function actionGetcodesale()
    {
        $post = $_POST;
        $email = isset($post['email']) && $post['email'] ? $post['email'] : '';
        if($email) {
            $code = CouponCode::getRandCodeSale();
            if($code) {
                $post['code'] = $code;
                $content = $this->renderPartial('ajax-get-sale-code',$post , true);
                $subject = isset($post['subject']) && $post['subject'] ? $post['subject'] : 'Thư gủi code khuyến mãi.';
                if ($content && $subject) {
                    if(Yii::app()->mailer->send("", $email, $subject, $content)) {
                        $this->jsonResponse(200, array(
                            'message' => 'success',
                            'html' => $code,
                        ));
                    }
                    //$mailer->send($from, $email, $subject, $message);
                }
            } else {
                $this->jsonResponse(400, array(
                    'message' => 'error',
                    'html' => 'Chường trình đã kết thúc hoặc đã hoặc đã hết mã giảm giá. Vui lòng quay lại khi có trương chình mới.',
                ));
            }
        } else {
            $this->jsonResponse(200, array(
                'message' => 'error - không thể gủi thông tin đến email.',
                'html' => $code,
            ));
        }
    }

}
