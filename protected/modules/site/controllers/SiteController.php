<?php

class SiteController extends PublicController
{

    public $layout = '//layouts/site';

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if (in_array($this->site_id, [1498,2071])) { // Hung Tuy, Carcam
            $servername = ClaSite::getServerName();
            $homeFull = ClaSite::getHttpMethod(true) . $servername;
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $homeFull");
        }
        //
        $this->layoutForAction = '//layouts/site_error';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else {
                if ($error['code'] == 404) {
                    return $this->redirect($this->actionNotfound());
//                    Yii::app()->clientScript->registerScript('notfound', 'setTimeout(function(){window.location.href="' . Yii::app()->homeUrl . '"},3500)');
                }
                $this->render('error', $error);
            }
        }
    }

    function actionNotfound()
    {
        if (in_array($this->site_id, array(963))) { // http://marcommate.com
            $servername = ClaSite::getServerName();
            $homeFull = ClaSite::getHttpMethod(true) . $servername;
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $homeFull");
        }
        header('HTTP/1.0 404 Not Found', true, 404);
        $this->layoutForAction = '//layouts/site_notfound';
//        Yii::app()->clientScript->registerScript('notfound', 'setTimeout(function(){window.location.href="' . Yii::app()->homeUrl . '"},3500)');
        $this->render('notfound');
    }

    /**
     * nhận mail
     */
    function actionReceivenewsletter()
    {
        //
        $this->layoutForAction = '//layouts/site_receivenewsletter';
        //
        $model = new Newsletters();
        $isAjax = Yii::app()->request->isAjaxRequest;
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['Newsletters'])) {
            $model->attributes = $_POST['Newsletters'];
//          Only higgsup.nanoweb.vn
            if ($this->site_id == 1881) {
                $newletter = Newsletters::model()->findByAttributes(array(
                    'site_id' => $this->site_id,
                    'email' => $_POST['Newsletters']['email'],
                ));
                if ($newletter) {
                    $newletter->delete();
                }
            }
//          =================x
            if ($model->save()) {
                if ($isAjax)
                    $this->jsonResponse(200, array(
                        'message' => '<p class="text-success">' . Yii::t('notice', 'receive_newsletter_success') . '</p>',
                    ));
                else {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'sendsuccess'));
                    $this->redirect(Yii::app()->homeUrl);
                }
            } else {
                if ($isAjax)
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
            }
        }
    }

//    add info to reviews
    function actionCustomerReviews()
    {
        $model = new CustomerReviews();
        $isAjax = Yii::app()->request->isAjaxRequest;
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['CustomerReviews'])) {
            $model->actived = 0;
            $model->attributes = $_POST['CustomerReviews'];
            if ($model->save()) {
                if ($isAjax)
                    $this->jsonResponse(200, array(
                        'message' => '<p class="text-success">' . Yii::t('notice', 'receive_customerreviews_success') . '</p>',
                    ));
                else {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'sendsuccess'));
                    $this->redirect(Yii::app()->homeUrl);
                }
            } else {
                if ($isAjax)
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
            }
        }
    }
    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new CustomerReviews;
            $model->unsetAttributes();
            if (isset($_POST['CustomerReviews'])) {
                $model->attributes = $_POST['CustomerReviews'];
            }
            if ($model->validate()) {
                $errors = $model->getErrors();
                if (isset($errors) && count($errors)) {
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                } else {
                    $this->jsonResponse(200);
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        //
        $this->layoutForAction = '//layouts/site_contact';
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('common', 'contact') => Yii::app()->createUrl('/site/site/contact'),
        );
        //
        $model = new Contacts;
        if (isset($_POST['Contacts'])) {
            $model->attributes = $_POST['Contacts'];
            if ($model->validate()) {
                $model->save(false);
                Yii::app()->user->setFlash('contact', Yii::t('contact', 'contact_success_msg'));
                $this->refresh();
            }
        }
        $this->pageTitle = $this->metakeywords = Yii::t('site', 'contact');

        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the contact page
     */
    public function actionExpertransContact()
    {
        //
        $model = new ExpertransContactFormModel();
        if (isset($_POST['ExpertransContactFormModel'])) {
            $model->attributes = $_POST['ExpertransContactFormModel'];

            if ($model->aff_id) {
                $affiliate = AffiliateLink::model()->findByPk($model->aff_id);
                if ($affiliate) {
                    $info = $affiliate->attributes;
                    //
                    $click = new AffiliateClick();
                    $click->user_id = $affiliate->user_id;
                    $click->affiliate_id = $model->aff_id;
                    $click->ipaddress = ClaUser::getClientIp();
                    $click->operating_system = ClaUserAccess::getOS();
                    if ($click->save()) {
                        $info['affiliate_click_id'] = $click->id;
                    }
                    //
                }
            }

            if ($model->validate()) {
                $model->status = ExpertransContactFormModel::STATUS_WAITING;
                $model->created_time = time();
                $model->isCheck = true;
                //

                //
                $model->save(false);
                Yii::app()->mailer->send('', $model->email, 'Chúng tôi đã tiếp nhân yêu cầu liên hệ', 'Chúng tôi đã tiếp nhận yêu cầu của bạn');
                Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], 'Có liên hệ mới', 'Bạn đã có 1 liên hệ mới vui lòng vào quản trị để check');
                Yii::app()->user->setFlash('contact', Yii::t('contact', 'contact_success_msg'));
                $this->jsonResponse(200, array());
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionCheckWarranty()
    {
        //
        $this->layoutForAction = '//layouts/site_checkwarranty';
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('common', 'warranty') => Yii::app()->createUrl('/site/site/checkWarranty'),
        );
        //
        $model = new Orders();
        $result = array();
        if (isset($_POST['Orders'])) {
            $phone = trim($_POST['Orders']['shipping_phone']);
            $model->shipping_phone = $phone;
            $site_id = Yii::app()->controller->site_id;
            $options = array(':site_id' => $site_id, 'phone' => $phone);
            $result = $model->count('site_id=:site_id AND (shipping_phone =:phone OR billing_phone=:phone )', $options);
//            if (count($result)) {
//                $dataProvider = new CActiveDataProvider('Post', array(
//                    'criteria' => array(
//                        'condition' => 'subject_id=2',
//                    ),
//                    'pagination' => array(
//                        'pageSize' => 20,
//                    ),
//                ));
//            }
            $dataProvider = new CActiveDataProvider('Orders', array(
                'criteria' => array(
                    'condition' => 'site_id=' . $site_id . ' AND (shipping_phone =' . $phone . ' OR billing_phone=' . $phone . ')'),
//                'countCriteria' => array(
//                    'condition' => 'site_id=80',
                // 'order' and 'with' clauses have no meaning for the count query
//                ),
                'pagination' => array(
                    'pageSize' => 100,
                )
            ));
            $this->render('check_warranty', array('model' => $model, 'result' => $result, 'dataProvider' => $dataProvider));
        } else {
            $this->render('check_warranty', array('model' => $model, 'result' => $result));
        }
    }

    /**
     * Check bảo hành
     * @author : Hatv
     */
    public function actionWarranty()
    {
        $this->layoutForAction = '//layouts/site_warranty';
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/site/site/checkWarranty'),
        );
        //
        $model = new ProductWarranty();
        $result = array();
        if ($_POST['ProductWarranty']['phone'] || $_POST['ProductWarranty']['imei']) {
            $phone = trim($_POST['ProductWarranty']['phone']);
            $imei = trim($_POST['ProductWarranty']['imei']);
//            $model->phone = $phone;
            $site_id = Yii::app()->controller->site_id;
            $condition = 'site_id = ' . $site_id;
            if ($phone) {
                $condition .= ' AND phone = ' . $phone;
            }
            if ($imei) {
                $condition .= ' AND status = 1';
                $condition .= ' AND imei = "' . $imei . '"';
            }
            $result = $model->count($condition);

            $dataProvider = new CActiveDataProvider('ProductWarranty', array(
                'criteria' => array(
                    'condition' => $condition),
                'pagination' => array(
                    'pageSize' => 100,
                )
            ));
            $this->render('warranty', array('model' => $model, 'result' => $result, 'dataProvider' => $dataProvider));
        } else {
            $this->render('warranty', array('model' => $model, 'result' => $result));
        }
    }

    /**
     * Check lịch sử bảo hành
     * @author: Hatv
     */
    public function actionWarrantyHistory()
    {
        $this->layoutForAction = '//layouts/site_warranty_history';
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/site/site/warrantyHistory'),
        );
        //
        $model = new ProductWarrantyHistory();
        $result = array();
        if (count($_POST['ProductWarrantyHistory'])) {
            $phone = trim($_POST['ProductWarrantyHistory']['phone']);
            $imei = trim($_POST['ProductWarrantyHistory']['imei']);
//            $model->phone = $phone;
            $site_id = Yii::app()->controller->site_id;

            $condition = 'site_id = ' . $site_id;
            if ($phone) {
                $condition .= ' AND phone = ' . $phone;
            }
            if ($imei) {
                $condition .= ' AND imei = "' . $imei . '"';
            }
            $result = $model->count($condition);
            $dataProvider = new CActiveDataProvider('ProductWarrantyHistory', array(
                'criteria' => array(
                    'condition' => $condition),
//                'pagination' => array(
//                    'pageSize' => 100,
//                )
            ));
            $this->render('warranty_history', array('model' => $model, 'result' => $result, 'dataProvider' => $dataProvider));
        } else {
            $this->render('warranty_history', array('model' => $model, 'result' => $result));
        }
    }

    /**
     * Giới thiệu
     */
    public function actionIntroduce()
    {
        //
        $this->layoutForAction = '//layouts/site_introduce';
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('common', 'introduce') => Yii::app()->createUrl('/site/site/introduce'),
        );
        //
        $introduce = SiteIntroduces::getIntroduce();
        //
        $data = $introduce['description'];
        //
        $this->pageTitle = $this->metakeywords = strip_tags($introduce['title']);


        $this->render('introduce', array(
            'introduce' => $introduce,
            'data' => $data,
        ));
    }

    function actionPricing()
    {
        //
        $this->layoutForAction = '//layouts/site_price';
        //
        if ($this->site_id != ClaSite::ROOT_SITE_ID)
            Yii::app()->end();
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('site', 'pricing') => Yii::app()->createUrl('/site/site/pricing'),
        );
        $this->render('price');
    }

    /**
     * set language for site
     */
    function actionSetlanguage()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (ClaSite::isMultiLanguage()) {
                $language = Yii::app()->request->getParam(ClaSite::LANGUAGE_KEY);
                $actionKey = Yii::app()->request->getParam(ClaSite::LANGUAGE_ACTION_KEY);
                if ($actionKey) {
                    $actionKey = json_decode(base64_decode($actionKey), true);
                }
                $languages = ClaSite::getLanguagesForSite();
                if (isset($languages[$language])) {
                    if (ClaSite::setPublicLanguageSession($language)) {
                        Yii::app()->language = $language;
                        Yii::app()->urlManager->addRules(ClaSite::getPublicSiteRules(), false);
                    }
                    $redirect = '';
                    if (isset($actionKey['url']) && isset($actionKey['params'])) {
                        unset($actionKey['params'][ClaSite::LANGUAGE_KEY]);
                        unset($actionKey['params'][ClaSite::LANGUAGE_ENCRYPTION]);
                        $redirect = Yii::app()->createUrl($actionKey['url'], $actionKey['params']);
                        if(!$redirect){
                            $redirect = Yii::app()->createAbsoluteUrl($actionKey['url'], $actionKey['params']);
                        }
                    }
                    $this->jsonResponse(200, array('redirect' => $redirect));
                }
            }
        }
    }

    /**
     * disable site
     */
    function actionDisable()
    {
        $this->layout = 'disable';
        $this->render('disable');
    }

    /**
     * dừng site để nâng cấp
     */
    function actionUpgrade()
    {
        $this->layout = 'upgrade';
        $this->render('upgrade');
    }

    function actionDetail($id)
    {
        $this->layout = 'site_detail';
        $site = SiteSettings::model()->findByPk($id);
        if (!$site) {
            $this->sendResponse(404);
        }

        $this->pageTitle = $this->metakeywords = $site['site_title'];
        if (isset($site['meta_keywords']) && $site['meta_keywords']) {
            $this->metakeywords = $site['meta_keywords'];
        }
        if (isset($site['meta_description']) && $site['meta_description']) {
            $this->metadescriptions = $site['meta_description'];
        }
        if (isset($site['meta_title']) && $site['meta_title']) {
            $this->metaTitle = $site['meta_title'];
        }
        if ($site['avatar_path'] && $site['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $site['avatar_path'] . 's1000_1000/' . $site['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));

        $site_introduce = SiteIntroduces::model()->findByPk($id);

        $hours = ClaService::getBusinessHours($id);

        // calculator rating
        $ratings = Rating::getRatings(Rating::RATING_BUSINESS, $id);
        $sum = 0;
        $rating_point = 0;
        $totalrating = 0;
        if (isset($ratings) && $ratings) {
            $totalrating = count($ratings);
            foreach ($ratings as $rating) {
                $sum += $rating['rating'];
            }
            $rating_point = $sum / $totalrating;
        }
        $ratinged = Rating::checkRatinged(Rating::RATING_BUSINESS, $id);
        $this->render('detail', array(
            'site' => $site,
            'site_introduce' => $site_introduce,
            'hours' => $hours,
            'rating_point' => $rating_point,
            'totalrating' => $totalrating,
            'ratinged' => $ratinged
        ));
    }

    public function actionReviews($id)
    {
        $this->layout = 'site_review';

        $site = SiteSettings::model()->findByPk($id);
        if (!$site) {
            $this->sendResponse(404);
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $ratings = Rating::getAllRatings(Rating::RATING_BUSINESS, $id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Rating::countRatings(Rating::RATING_BUSINESS, $id);
        //
        // calculator rating
        $ratings_temp = Rating::getRatings(Rating::RATING_BUSINESS, $id);
        $sum = 0;
        $rating_point = 0;
        $totalrating = 0;
        if (isset($ratings_temp) && $ratings_temp) {
            $totalrating = count($ratings_temp);
            foreach ($ratings_temp as $rating) {
                $sum += $rating['rating'];
            }
            $rating_point = $sum / $totalrating;
        }
        $ratinged = Rating::checkRatinged(Rating::RATING_BUSINESS, $id);
        $this->render('reviews', array(
            'site' => $site,
            'ratings' => $ratings,
            'totalitem' => $totalitem,
            'rating_point' => $rating_point,
            'totalrating' => $totalrating,
            'ratinged' => $ratinged
        ));
    }

    public function actionListSitesNail()
    {
        $this->layout = 'site_list';
        //
        $zipcode = Yii::app()->request->getParam('zc', '');
        $service_name = Yii::app()->request->getParam('sn', '');
        $type_service = Yii::app()->request->getParam('t', '');
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $options = array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'zipcode' => $zipcode,
            'service_name' => $service_name,
            'type_service' => $type_service,
        );
        $range = Yii::app()->request->getParam('range', '');
        $lat = Yii::app()->request->getParam('lat', '');
        $long = Yii::app()->request->getParam('lng', '');
        if ($range && $lat && $long) {
            $options = array_merge($options, array(
                'range' => $range,
                'lat' => $lat,
                'lng' => $long,
            ));
        }
        $listsites = SiteSettings::getSiteInType(ClaSite::SITE_TYPE_NAIL, $options);
        //
        $totalitem = SiteSettings::countSiteInType(ClaSite::SITE_TYPE_NAIL, array(
            'zipcode' => $zipcode,
            'service_name' => $service_name,
            'type_service' => $type_service
        ));
        //
        $this->render('list_nail', array(
            'listsites' => $listsites,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'range' => $range,
            'lat' => $lat,
            'lng' => $long,
        ));
    }

    //
    function actionTestmail()
    {
        var_dump(Yii::app()->mailer->send('', 'minhcoltech@gmail.com', 'test', 'OK'));
        $headers = array();
        //var_dump(@mail('minhcoltech@gmail.com', 'test', 'OK', $headers));
        die('123');
    }

    //
    function actionTestsms()
    {
        $message = Yii::app()->smser->send('+84abc123agc,+841695211028', '[Nano] Test');
        if (!$message) {
            $errors = Yii::app()->smser->getErrors();
            var_dump($errors);
        }
        die('123');
    }

    function actionCopywidget()
    {
        if (ClaSite::ShowModule() && ClaSite::isMultiLanguage()) {
            $session = Yii::app()->session['copywidget'];
            //$session = false;
            if (!$session) {
                //Yii::app()->session['copywidget'] = true;
                $language = Yii::app()->request->getParam(ClaSite::LANGUAGE_KEY, 'en');
                $pagewidges = Widgets::getWidgets();
                $startTime = microtime(true);
                foreach ($pagewidges as $pw) {
                    $pageWidgetModel = new PageWidgets();
                    $pageWidgetModel->setLanguage($language, true);
                    $pageWidgetModel->attributes = $pw;
                    unset($pageWidgetModel->page_widget_id);
                    if ($pageWidgetModel->save()) {
                        $pageWidgetConfig = PageWidgetConfig::model()->findByAttributes(array('page_widget_id' => $pw['page_widget_id']));
                        if ($pageWidgetConfig) {
                            $newPWC = new PageWidgetConfig();
                            $newPWC->setLanguage($language, true);
                            $newPWC->attributes = $pageWidgetConfig->attributes;
                            unset($newPWC->id);
                            $newPWC->page_widget_id = $pageWidgetModel->page_widget_id;
                            Yii::app()->db->createCommand()->insert($newPWC->tableName(), $newPWC->attributes);
                        }
                    }
                }
                $endTime = microtime(true);
                echo "Time: " . ($endTime - $startTime) . "\n";
            }
        }
        echo "Have nothing";
        Yii::app()->end();
    }

    /**
     * enable, disable edit module for admin
     */
    function actionEditmodule()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $admin = ClaSite::getAdminSession();
            if (isset($admin['user_id'])) {
                $value = (int)Yii::app()->request->getParam('value', '');
                if ($value) {
                    Yii::app()->session[ClaSite::ENABLE_EDIT_MODULE_SESSION] = $value;
                } else {
                    unset(Yii::app()->session[ClaSite::ENABLE_EDIT_MODULE_SESSION]);
                }
                $this->jsonResponse(200);
            }
        };
        $this->jsonResponse(400);
    }

    /**
     * Create site map normal
     * @return boolean
     */
    function actionCreatesitemap()
    {
        self::createSiteMapFromMenu();
        ClaSite::createSiteRobot();
        Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
        $this->redirect(Yii::app()->homeUrl);
        Yii::app()->end();
    }


    /**
     * Create Site Map From Menu
     */
    static function createSiteMapFromMenu()
    {
        // Lấy lại site info ko dùng Yii::app()->siteinfo['domain_default']
        $siteInfo = ClaSite::getSiteInfo();
        //
        $data = self::getSiteMapDataFromMenu($siteInfo);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/' . $siteInfo['domain_default'] . '_sitemap.xml';
        if (file_put_contents($file, $data)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    /**
     * get site map data from menu
     * @return string
     */
    static function getSiteMapDataFromMenu($siteinfo = array())
    {
        // Menu
        $menus = Menus::getAllMenuInSite();
        // Product Detail
        $products = Product::model()->findAllByAttributes(array('site_id' => Yii::app()->controller->site_id, 'status' => true));
        // News Detail
        $news = News::model()->findAllByAttributes(array('site_id' => Yii::app()->controller->site_id, 'status' => true));
        // Trang nội dung
        $category_pages = CategoryPage::model()->findAllByAttributes(array('site_id' => Yii::app()->controller->site_id));

        $defaultDomain = isset($siteinfo['domain_default']) ? $siteinfo['domain_default'] : '';
        $hostInfo = ($defaultDomain) ? ClaSite::getHttpMethod() . $defaultDomain : Yii::app()->request->hostInfo;
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";
        // trang chủ
        $lastmod = date('Y-m-d');
        $str .= '<url>'
            . '<loc>'
            . $hostInfo
            . '</loc>'
            . '<lastmod>' . $lastmod . '</lastmod>'
            . '<changefreq>daily</changefreq>'
            . '<priority>1.0</priority>'
            . '</url>' . "\n";
        $temp[$hostInfo] = true;
        //
        foreach ($menus as $menu) {
            $priority = '1.0';
            $list_baseoath = array('/economy/product/detail', '/news/news/detail');
            if (in_array($menu['menu_basepath'], $list_baseoath)) {
                $priority = '0.5';
            }
            $url = '';
            if (($menu['menu_basepath'] || $menu['menu_pathparams']) && $menu['menu_linkto'] == Menus::LINKTO_INNER) {
                $url = Yii::app()->createAbsoluteUrl($menu['menu_basepath'], json_decode($menu['menu_pathparams'], true));
            } else {
                if ($menu['menu_link'] && strpos($menu['menu_link'], $defaultDomain) !== false)
                    $url = $menu['menu_link'];
            }
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>weekly</changefreq>'
                . '<priority>' . $priority . '</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        foreach ($products as $product) {
            $product = $product->attributes;
            $url = Yii::app()->createAbsoluteUrl('economy/product/detail', ["id" => $product["id"], "alias" => $product["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>weekly</changefreq>'
                . '<priority>0.5</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        foreach ($news as $new) {
            $new = $new->attributes;
            $url = Yii::app()->createAbsoluteUrl('news/news/detail', ["id" => $new["news_id"], "alias" => $new["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>weekly</changefreq>'
                . '<priority>0.5</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }

        foreach ($category_pages as $category_page) {
            $category_page = $category_page->attributes;
            $url = Yii::app()->createAbsoluteUrl('/page/category/detail', ["id" => $category_page["id"], "alias" => $category_page["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>weekly</changefreq>'
                . '<priority>0.5</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }

        //
        $str .= '</urlset>' . "\n";
        unset($temp);
        //
        return $str;
    }

    /**
     * Page Site Map : Get News cate, Tour cate, Tour, News
     * #author: Hatv
     */
    function actionSitemapPageNew()
    {
        $child_category = new ClaCategory();
        //
        $child_category->type = ClaCategory::CATEGORY_NEWS;
        $child_category->generateCategory();
        $newsCategories = $child_category->createArrayCategory(0);

        $child_category->type = ClaCategory::CATEGORY_PRODUCT;
        $child_category->generateCategory();
        $productCategories = $child_category->createArrayCategory(0);
        //
        $news = [];
        $products = [];
        //

        $newsAll = News::model()->findAllByAttributes(
            array('site_id' => Yii::app()->controller->site_id, 'status' => true),
            array('limit' => 1000));
        $productAll = Product::model()->findAllByAttributes(
            array('site_id' => Yii::app()->controller->site_id, 'status' => true),
            array('limit' => 2000));
        //
        if ($newsAll) {
            foreach ($newsAll as $new) {
                $news[$new->news_category_id][] = $new->attributes;
            }
        }

        if ($productAll) {
            foreach ($productAll as $product) {
                $products[$product->product_category_id][] = $product->attributes;
            }
        }

        $menus = Menus::getAllMenuInSite();

        //
        $this->render('sitemappagenew', array(
            'news' => $news,
            'products' => $products,
            'newsCategories' => $newsCategories,
            'productCategories' => $productCategories,
            'menus' => $menus
        ));
    }


    /**
     * Page Site Map : Get News cate, Tour cate, Tour, News
     * #author: Hatv
     */
    function actionSitemapPage()
    {
        $child_category = new ClaCategory();
        //
        $child_category->type = ClaCategory::CATEGORY_TOUR;
        $child_category->generateCategory();
        $tourCategories = $child_category->createArrayCategory(0);
        //
        $child_category->type = ClaCategory::CATEGORY_NEWS;
        $child_category->generateCategory();
        $newsCategories = $child_category->createArrayCategory(0);
        //
        $tours = [];
        $news = [];
        //
        $toursAll = Tour::model()->findAllByAttributes(
            array('site_id' => Yii::app()->controller->site_id, 'status' => true),
            array('select' => 'name,id,tour_category_id,alias', 'limit' => 1000));
        $newsAll = News::model()->findAllByAttributes(
            array('site_id' => Yii::app()->controller->site_id, 'status' => true),
            array('limit' => 1000));
        //
        if ($toursAll) {
            foreach ($toursAll as $tour) {
                $tours[$tour->tour_category_id][] = $tour->attributes;
            }
        }
        if ($newsAll) {
            foreach ($newsAll as $new) {
                $news[$new->news_category_id][] = $new->attributes;
            }
        }

        $menus = Menus::getAllMenuInSite();

        //
        $this->render('sitemappage', array(
            'news' => $news,
            'tours' => $tours,
            'tourCategories' => $tourCategories,
            'newsCategories' => $newsCategories,
            'menus' => $menus
        ));
    }

    /**
     * Create site map new split page
     * @return boolean
     */
    function actionCreateSiteMapToManyFile()
    {
        $siteInfo = ClaSite::getSiteInfo();
        self::createSiteMapFromProductCategory();
        self::createSiteMapFromNewsCategory();
        self::createSiteMapFromProduct();
        self::createSiteMapFromNews();
        $arySiteMap = [
            'sitemap/sitemap_' . $siteInfo['domain_default'] . '_product_category.xml',
            'sitemap/sitemap_' . $siteInfo['domain_default'] . '_news_category.xml',
            'sitemap/sitemap_' . $siteInfo['domain_default'] . '_product.xml',
            'sitemap/sitemap_' . $siteInfo['domain_default'] . '_news.xml',
        ];
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style2.xsl"?>' . "\n";
        $str .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        // trang chủ
        $lastmod = date('Y-m-d');
        foreach ($arySiteMap as $item) {
            $str .= '<sitemap>'
                . '<loc>'
                . Yii::app()->createAbsoluteUrl($item)
                . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '</sitemap>' . "\n";
        }
        $str .= '</sitemapindex>';
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/' . $siteInfo['domain_default'] . '_sitemap.xml';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
        }
        //
        ClaSite::createSiteRobot();
        Yii::app()->user->setFlash('success', Yii::t('common', 'Update Sitemap Sucsess!'));
        $this->redirect(Yii::app()->homeUrl);
        Yii::app()->end();
    }

    // create site map from categry
    static function createSiteMapFromProductCategory()
    {
        $siteInfo = ClaSite::getSiteInfo();
        // Danh mục sản phẩm
        $child_category = new ClaCategory();
        $child_category->type = ClaCategory::CATEGORY_PRODUCT;
        $child_category->generateCategory();
        $categories = $child_category->getListItems();

        $defaultDomain = isset($siteinfo['domain_default']) ? $siteInfo['domain_default'] : '';
        $hostInfo = ($defaultDomain) ? ClaSite::getHttpMethod() . $defaultDomain : Yii::app()->request->hostInfo;
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";

        // Trang chủ
        $lastmod = date('Y-m-d');
        $str .= '<url>'
            . '<loc>'
            . $hostInfo
            . '</loc>'
            . '<lastmod>' . $lastmod . '</lastmod>'
            . '<changefreq>daily</changefreq>'
            . '<priority>1.0</priority>'
            . '</url>' . "\n";
        $temp[$hostInfo] = true;

        foreach ($categories as $key => $value) {
            $lastmod = date('Y-m-d', $value['modified_time']);
            $url = Yii::app()->createAbsoluteUrl('/economy/product/category', array("id" => $value["cat_id"], "alias" => $value["alias"]));
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>daily</changefreq>'
                . '<priority>0.9</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        //
        $str .= '</urlset>' . "\n";
        unset($temp);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/sitemap_' . $siteInfo['domain_default'] . '_product_category.xml';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    // create site map from categry
    static function createSiteMapFromNewsCategory()
    {
        $siteInfo = ClaSite::getSiteInfo();
        // Danh mục sản phẩm
        $child_category = new ClaCategory();
        $child_category->type = ClaCategory::CATEGORY_NEWS;
        $child_category->generateCategory();
        $categories = $child_category->getListItems();

        $defaultDomain = isset($siteinfo['domain_default']) ? $siteInfo['domain_default'] : '';
        $hostInfo = ($defaultDomain) ? ClaSite::getHttpMethod() . $defaultDomain : Yii::app()->request->hostInfo;
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";

        // Trang chủ

        foreach ($categories as $key => $value) {
            $lastmod = date('Y-m-d');
            $url = Yii::app()->createAbsoluteUrl('/news/news/category', ["id" => $value["cat_id"], "alias" => $value["alias"]]);
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>daily</changefreq>'
                . '<priority>0.9</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        //
        $str .= '</urlset>' . "\n";
        unset($temp);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/sitemap_' . $siteInfo['domain_default'] . '_news_category.xml';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    // create site map from product
    static function createSiteMapFromProduct()
    {
        $siteInfo = ClaSite::getSiteInfo();
        // Product Detail
        $products = Product::model()->findAllByAttributes(array('site_id' => Yii::app()->controller->site_id, 'status' => true));
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";
        //
        foreach ($products as $product) {
            $product = $product->attributes;
            $lastmod = date('Y-m-d', $product['modified_time']);
            $url = Yii::app()->createAbsoluteUrl('economy/product/detail', ["id" => $product["id"], "alias" => $product["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>daily</changefreq>'
                . '<priority>0.8</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        //
        $str .= '</urlset>' . "\n";
        unset($temp);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/sitemap_' . $siteInfo['domain_default'] . '_product.xml';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    // create site map from news
    static function createSiteMapFromNews()
    {
        $siteInfo = ClaSite::getSiteInfo();
        // =News
        $news = News::model()->findAllByAttributes(array('site_id' => Yii::app()->controller->site_id, 'status' => true));
        $temp = array();
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<?xml-stylesheet type="text/xsl" href="/sitemap/style.xsl"?>' . "\n";
        $str .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";
        // trang chủ
        //
        foreach ($news as $new) {
            $new = $new->attributes;
            $lastmod = date('Y-m-d', $new['modified_time']);
            $url = Yii::app()->createAbsoluteUrl('news/news/detail', ["id" => $new["news_id"], "alias" => $new["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $lastmod = date('Y-m-d', $new['modified_time']);
            $str .= '<url>'
                . '<loc>' . $url . '</loc>'
                . '<lastmod>' . $lastmod . '</lastmod>'
                . '<changefreq>daily</changefreq>'
                . '<priority>0.8</priority>'
                . '</url>' . "\n";

            $temp[$url] = true;
        }
        //
        $str .= '</urlset>' . "\n";
        unset($temp);
        //
        $file = Yii::getPathOfAlias('common') . '/../' . 'sitemap' . '/sitemap_' . $siteInfo['domain_default'] . '_news.xml';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
            return true;
        }
        return false;
    }

    public function actionRss()
    {
        $this->layoutForAction = '//layouts/news';
        $news = News::getNewNews(array('limit' => 10));
        //
        $hotNews = News::getHotNews(array('limit' => 5));
        //
        $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $str .= '<rss version="2.0" xmlns:slash="http://purl.org/rss/1.0/modules/slash/">' . "\n";
        $str .= '<channel>' . "\n";
        $str .= '<title>' . Yii::app()->siteinfo['site_title'] . '</title>' . "\n";
        $str .= '<link>http://' . Yii::app()->siteinfo['domain_default']. '/feed</link>' . "\n";
        $str .= '<description>' . Yii::app()->siteinfo['meta_description'] . '</description>' . "\n";
        // trang chủ
        $lastmod = date('Y-m-d');

        foreach ($hotNews as $news_id => $new) {
            $url = Yii::app()->createAbsoluteUrl('news/news/detail', ["id" => $new["news_id"], "alias" => $new["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<item>' . "\n"
                . ' <title>' . $new['news_title'] . '</title>' . "\n"
                . ' <description>' . strip_tags($new['news_sortdesc']) . '</description>' . "\n"
                . ' <pubDate>' . date('D, d M Y H:i:s O', $new['publicdate']) . '</pubDate>'
                . ' <link>' . $url . '</link>' . "\n"
                . ' </item>' . "\n";
            $temp[$url] = true;
        }

        foreach ($news as $news_id => $new) {
            $url = Yii::app()->createAbsoluteUrl('news/news/detail', ["id" => $new["news_id"], "alias" => $new["alias"]]);
            //
            if (!$url)
                continue;
            if (isset($temp[$url]))
                continue;
            //
            $str .= '<item>' . "\n"
                . '<title>' . $new['news_title'] . '</title>' . "\n"
                . '<description>' . strip_tags($new['news_sortdesc'])  . '</description>' . "\n"
                . ' <pubDate>' . date('D, d M Y H:i:s O', $new['publicdate']) . '</pubDate>'
                . '<link>' . $url . '</link>' . "\n"
                . '</item>' . "\n";
            $temp[$url] = true;
        }

        $str .= '</channel>' . "\n";
        $str .= '</rss>' . "\n";
        echo $str;
    }

    function actionCopyMailsettings() {
        $sql = 'SELECT site_id FROM sites';
        $ids = Yii::app()->db->createCommand($sql)->queryColumn();
        $model_mails = new MailSettings();
        $sql_mail = 'SELECT * FROM mail_settings';
        $mails = Yii::app()->db->createCommand($sql_mail)->queryAll();

        foreach ($mails as $mail) {
            foreach ($ids as $id) {
                if ($mail['site_id'] != $id) {
                    $model_mails = new MailSettings();
                    $model_mails->attributes = $mail;
                    $model_mails->mail_attribute = $mail['mail_attribute'];
                    $model_mails->site_id = $id;
                    $model_mails->save();
                }
            }
        }
        echo 'xong xeng';
        die();
    }
    
    function actionUpdaterobots(){
        // bỏ disallow in robots
        $sql = 'SELECT * FROM sites';
        $ids = Yii::app()->db->createCommand($sql)->queryAll();
        foreach($ids as $site){
            ClaSite::createSiteRobot($site);
        }
        //
        echo 'Done! ';
        die('OK!');
    }

}
