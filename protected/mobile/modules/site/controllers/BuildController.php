<?php

class BuildController extends PublicController {

    public $layout = '//layouts/build';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
            ),
        );
    }

    /**
     * chọn theme
     */
    function actionChoicetheme() {
        //
        $cat_id = Yii::app()->request->getParam('cid');
        //
        $pagesize = 30;
        $pagesize = $pagesize - 1;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $options = array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'cat_id' => $cat_id,
        );
        $themes = Themes::getThemes($options);
        $totalItems = Themes::countThemes($options);
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_THEME, 'create' => true));
        $data = $category->createArrayCategory();
        //
        $this->render('choicetheme', array(
            'themes' => $themes,
            'data' => $data,
            'pagesize' => $pagesize,
            'totalItems' => $totalItems,
        ));
    }

    /**
     * chọn theme
     */
    function actionChoiceThemeWidget() {
        //
        $cat_id = Yii::app()->request->getParam('cid');
        //
        $pagesize = 30;
        $pagesize = $pagesize - 1;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $options = array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'cat_id' => $cat_id,
        );
        $themes = Themes::getThemes($options);
        $totalItems = Themes::countThemes($options);
        //
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_THEME, 'create' => true));
        $data = $category->createArrayCategory();
        //
        $this->render('choicetheme', array(
            'themes' => $themes,
            'data' => $data,
            'pagesize' => $pagesize,
            'totalItems' => $totalItems,
        ));
    }

    /**
     * Tạo web
     */
    public function actionInstall() {
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        $theme_id = Yii::app()->request->getParam('theme');
        if (!$theme_id) {
            if ($isAjax)
                $this->jsonResponse(404);
            else
                $this->redirect(Yii::app()->createUrl('site/build/choicetheme'));
        }
        $theme = Themes::model()->findByPk($theme_id);
        if (!$theme || $theme->status != Themes::STATUS_AVAILABLE) {
            if ($isAjax)
                $this->jsonResponse(400);
            else
                $this->redirect(Yii::app()->createUrl('site/build/choicetheme'));
        }
        //
        $model = new BuildRegisterForm();
        $dataPath = $theme->getPathOfDefaultData();
        if (!file_exists($dataPath)) {
            if ($isAjax)
                $this->jsonResponse(400, array('mess' => $dataPath));
            else
                $this->redirect(Yii::app()->createUrl('site/build/choicetheme'));
        }
        //
        //
        if (isset($_POST['BuildRegisterForm'])) {
            $model->attributes = $_POST['BuildRegisterForm'];
            if ($model->validate()) {
                $userAdmin = new UsersAdmin();
                $userAdmin->email = $model->email;
                $userAdmin->user_name = $model->email;
                //
                $passwordStore = $model->password;
                //
                $userAdmin->password = ClaGenerate::encrypPassword($model->password);
                //create user admin
                if ($userAdmin->save()) {
                    $site = new SiteSettings();
                    $site->site_type = $theme->theme_type;
                    $site->site_title = $model->domain;
                    $site->site_skin = $theme->theme_id;
                    $site->admin_email = $model->email;
                    $site->domain_default = $model->getRealDomain();
                    $site->user_id = $userAdmin->user_id;
                    //save site
                    if ($site->save()) {
                        //
                        $userAdmin->site_id = $site->site_id;
                        $userAdmin->save();
                        //
                        $domain = new Domains();
                        $domain->domain_id = $model->getRealDomain();
                        $domain->site_id = $site->site_id;
                        $domain->user_id = $userAdmin->user_id;
                        $domain->domain_default = Domains::DOMAIN_DEFAULT_YES;
                        // create domain
                        if ($domain->save()) {
                            // insert default data for site
                            $sql = '';
                            $sql = trim(file_get_contents($dataPath));
                            $sql = str_replace(array('[site_id]', '[user_id]', '[now]'), array($site->site_id, $userAdmin->user_id, time()), $sql);
                            if ($sql) {
                                $transaction = Yii::app()->db->beginTransaction();
                                try {
                                    $respond = Yii::app()->db->createCommand($sql)->execute();
                                    $transaction->commit();
                                    if ($respond) {
                                        $redirect = ClaSite::getHttpMethod() . $domain->domain_id . '/' . ClaSite::getAdminEntry();
                                        //
                                        // Auto login
                                        $token = ClaGenerate::getUniqueCode();
                                        $cacheFile = new ClaCacheFile();
                                        $loginForm = New LoginForm();
                                        $loginForm->username = $userAdmin->email;
                                        $loginForm->password = $userAdmin->password;
                                        $loginForm->rememberMe = 1;
                                        //
                                        $cacheFile->add($token, $loginForm->attributes);
                                        //
                                        $loginredirect = ClaSite::getHttpMethod() . $domain->domain_id . '/' . ClaSite::getAdminEntry() . '/login/login/tklogin?tk=' . $token;
                                        // send mail 
                                         $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                            'mail_key' => 'registersuccess',
                                        ));
                                        if ($mailSetting) {
                                            $data = array(
                                                'site' => ClaSite::getHttpMethod() . $domain->domain_id,
                                                'date' => date('d-m-Y'),
                                                'website_name' => $model->domain,
                                                'admin_username' => $userAdmin->email,
                                                'admin_password' => $passwordStore,
                                                'site_admin' => $redirect,
                                                'ip' => Yii::app()->params['ipssystem'][0],
                                            );
                                            //
                                            $content = $mailSetting->getMailContent($data);
                                            //
                                            $subject = $mailSetting->getMailSubject($data);
                                            //
                                            if ($content && $subject) {
                                                Yii::app()->mailer->send('', $userAdmin->email, $subject, $content);
                                                //$mailer->send($from, $email, $subject, $message);
                                            }
                                        }
                                        //
                                        $time = 30;
                                        if ($isAjax) {
                                            $this->jsonResponse(200, array(
                                                'message' => $this->renderPartial('registerSuccess', array(
                                                    'user' => $userAdmin,
                                                    'domain' => $domain,
                                                    'website' => ClaSite::getHttpMethod() . $domain->domain_id,
                                                    'admin_link' => $redirect,
                                                    'time' => $time,
                                                        ), true, true),
                                                'autologin' => $loginredirect,
                                                'redirect' => $redirect,
                                                'time' => $time,
                                            ));
                                        }
                                        //
                                        header("Location:" . $redirect);
                                    } else {
//                                    var_dump($respond);
//                                    echo $sql;
//                                    die;
                                    }
                                } catch (Exception $e) {
                                    $transaction->rollback();
                                    $this->redirect(Yii::app()->createUrl('site/build/choicetheme'));
                                }
                            }
                            //
                        }
                        //
                    }
                }
                //
            } else if ($isAjax) {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
        $theme_relaction = Themes::getThemeInRelaction($theme_id, array(
                    'cat_id' => $theme['category_id'],
                    'created_time' => $theme['created_time'],
        ));
        //
        $theme_relaction = ClaArray::getRandomInArray($theme_relaction, 3);
        //
        $this->render('register', array(
            'theme' => $theme,
            'model' => $model,
            'themerelaction' => $theme_relaction,
        ));
    }

    /**
     * Tự động tạo ra file sql
     * array("table" => array("id" => array("map"=>"tên biến trong sql")))
     */
    function actionGeneratesql() {
        // sql
        $sql = '';
        // mảng lưu trữ các biến và map giữa các biến trong php và mysql
        $store = array();
        /**
         * Tạo ra banner group -> banner
         */
        // Cập nhật thông tin của site
        $siteInfo = Yii::app()->siteinfo;
        $sql.="UPDATE " . Yii::app()->params['tables']['site'] . " SET site_logo=" . ClaGenerate::quoteValue($siteInfo['site_logo']) . ",footercontent=" . ClaGenerate::quoteValue($siteInfo['footercontent'])
                . " WHERE site_id=[site_id];" . "\n\n";
        // Lấy giới thiệu website
        $introduce = SiteIntroduces::getIntroduce();
        if ($introduce && count($introduce)) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['site_introduce'] . " (site_id,title,user_id, sortdesc, description, image_path, image_name, meta_keywords, meta_description, meta_title, created_time, modified_time) "
                    . "VALUES ([site_id],[user_id]," . ClaGenerate::quoteValue($introduce['title']) . ','.ClaGenerate::quoteValue($introduce['sortdesc']) . ','. ClaGenerate::quoteValue($introduce['description'])
                    . ',' . ClaGenerate::quoteValue($introduce['image_path']) . ',' . ClaGenerate::quoteValue($introduce['image_name']) . ',' . ClaGenerate::quoteValue($introduce['meta_keywords'])
                    . ',' . ClaGenerate::quoteValue($introduce['meta_description']) . ',' . ClaGenerate::quoteValue($introduce['meta_title']) . ',[now],[now]);';
            //
            $sql.="\n\n";
        }
        //
        //Lấy bản đồ
        $maps = Maps::getMaps(array('limit' => 100));
        if ($maps && count($maps)) {
            foreach ($maps as $map) {
                $sql.="INSERT INTO " . Yii::app()->params['tables']['map'] . " (id,site_id, user_id, latlng, `name`, address, email, phone, website, headoffice, `order`, created_time, modified_time) ";
                $sql.= "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($map['latlng']).','. ClaGenerate::quoteValue($map['name']).','. ClaGenerate::quoteValue($map['address']).','
                        . ClaGenerate::quoteValue($map['email']).','. ClaGenerate::quoteValue($map['phone']).','. ClaGenerate::quoteValue($map['website']).','.$map['headoffice'].','.$map['order']
                        . ",[now],[now]);"."\n";
                //$sql.= "set @" . Yii::app()->params['tables']['map'] . $map['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                //$store[Yii::app()->params['tables']['map']][$map['id']]['map'] = Yii::app()->params['tables']['map'] . $map['id'];
            }
            $sql.="\n\n";
        }
        // Lấy baner group -> Và tạo ra bannder group
        $bannergroups = Banners::getAllBannerGroup();
        foreach ($bannergroups as $bg) {
            $sql.= "INSERT INTO `" . Yii::app()->params['tables']['banner_group'] . "` VALUES (null, " . ClaGenerate::quoteValue($bg['banner_group_name']) . ", " . ClaGenerate::quoteValue($bg['banner_group_description']) . ", '[site_id]', '[user_id]', '" . $bg['width'] . "', '" . $bg['height'] . "', '[now]');" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['banner_group'] . $bg['banner_group_id'] . " = LAST_INSERT_ID();" . "\n";
            $store[Yii::app()->params['tables']['banner_group']][$bg['banner_group_id']]['map'] = Yii::app()->params['tables']['banner_group'] . $bg['banner_group_id'];
        }
        $sql.="\n\n";
        //Lấy banner
        $banners = Banners::getAllBanner();
        $bannercount = count($banners);
        if ($banners && $bannercount) {
            $i = 0;
            $sql.="INSERT INTO " . Yii::app()->params['tables']['banner'] . " (banner_id, site_id, banner_group_id, banner_name, banner_description, banner_src, banner_width, banner_height, banner_link, banner_type, banner_order, banner_rules, banner_target, created_time, banner_showall) VALUES " . "\n";
            foreach ($banners as $banner) {
                $i++;
                $sql.="(null, [site_id]," . (isset($store[Yii::app()->params['tables']['banner_group']][$banner['banner_group_id']]['map']) ? "@" . $store[Yii::app()->params['tables']['banner_group']][$banner['banner_group_id']]['map'] : 0)
                        . ", " . ClaGenerate::quoteValue($banner['banner_name']) . "," . ClaGenerate::quoteValue($banner['banner_description']) . "," . ClaGenerate::quoteValue($banner['banner_src'])
                        . "," . $banner['banner_width'] . "," . $banner['banner_height'] . "," . ClaGenerate::quoteValue($banner['banner_link']) . "," . $banner['banner_type'] . "," . $banner['banner_order']
                        . "," . ClaGenerate::quoteValue($banner['banner_rules']) . "," . $banner['banner_target'] . "," . $banner['created_time'] . "," . $banner['banner_showall'] . ")"
                        . (($i == $bannercount) ? ";" : ",") . "\n";
            }
        }
        $sql.="\n\n";
        //
        //Lấy danh mục tin tức
        $newscategories = NewsCategories::getAllCategory();
        foreach ($newscategories as $nc) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['newcategory'] . " (cat_id, site_id, user_id, cat_parent, cat_name, alias, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description) "
                    . "VALUES (null,[site_id],[user_id]," . (isset($store[Yii::app()->params['tables']['newcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['newcategory']][$nc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                    . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path']) . ","
                    . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . ");" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['newcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['newcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['newcategory'] . $nc['cat_id'];
        }
        //
        //Tin tức
        $news = News::getAllNews(array('limit' => 1000));
        foreach ($news as $ne) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['news'] . " (news_id, news_category_id, news_title, news_sortdesc, news_desc, alias, `status`, meta_keywords, meta_description, site_id, user_id, image_path, image_name, created_time, modified_time, modified_by, news_hot, news_source, poster, publicdate) ";
            $sql.= "VALUES (null,@" . $store[Yii::app()->params['tables']['newcategory']][$ne['news_category_id']]['map'] . "," . ClaGenerate::quoteValue($ne['news_title'])
                    . "," . ClaGenerate::quoteValue($ne['news_sortdesc']) . "," . ClaGenerate::quoteValue($ne['news_desc'])
                    . "," . ClaGenerate::quoteValue($ne['alias']) . "," . $ne['status'] . "," . ClaGenerate::quoteValue($ne['meta_keywords']) . "," . ClaGenerate::quoteValue($ne['meta_description'])
                    . ",[site_id],[user_id]," . ClaGenerate::quoteValue($ne['image_path']) . "," . ClaGenerate::quoteValue($ne['image_name']) . ",[now], [now],[user_id],"
                    . $ne['news_hot'] . "," . ClaGenerate::quoteValue($ne['news_source']) . "," . ClaGenerate::quoteValue($ne['poster']) . ",[now]);";
            $sql.= "set @" . Yii::app()->params['tables']['news'] . $ne['news_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['news']][$ne['news_id']]['map'] = Yii::app()->params['tables']['news'] . $ne['news_id'];
        }
        $sql.="\n\n";
        //
        // Lấy danh mục bài viết
        $postscategories = PostCategories::getAllCategory();
        foreach ($postscategories as $nc) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['postcategory'] . " (cat_id, site_id, user_id, cat_parent, cat_name, alias, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description) "
                    . "VALUES (null,[site_id],[user_id]," . (isset($store[Yii::app()->params['tables']['postcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['postcategory']][$nc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                    . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path']) . ","
                    . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . ");" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['postcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['postcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['postcategory'] . $nc['cat_id'];
        }
        // Lấy bài viết
        $news = Posts::getAllPosts(array('limit' => 1000));
        foreach ($news as $ne) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['post'] . " (id, category_id, title, sortdesc, description, alias, `status`, meta_keywords, meta_description, site_id, user_id, image_path, image_name, created_time, modified_time, modified_by, publicdate) ";
            $sql.= "VALUES (null,@" . $store[Yii::app()->params['tables']['postcategory']][$ne['category_id']]['map'] . "," . ClaGenerate::quoteValue($ne['title'])
                    . "," . ClaGenerate::quoteValue($ne['sortdesc']) . "," . ClaGenerate::quoteValue($ne['description'])
                    . "," . ClaGenerate::quoteValue($ne['alias']) . "," . $ne['status'] . "," . ClaGenerate::quoteValue($ne['meta_keywords']) . "," . ClaGenerate::quoteValue($ne['meta_description'])
                    . ",[site_id],[user_id]," . ClaGenerate::quoteValue($ne['image_path']) . "," . ClaGenerate::quoteValue($ne['image_name']) . ",[now], [now],[user_id],"
                    . "[now]);";
            $sql.= "set @" . Yii::app()->params['tables']['post'] . $ne['id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['post']][$ne['id']]['map'] = Yii::app()->params['tables']['post'] . $ne['id'];
        }
        $sql.="\n\n";
        //
        //Danh mục sản phẩm
        $productcategories = ProductCategories::getAllCategory();
        foreach ($productcategories as $nc) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['productcategory'] . " (cat_id, site_id, cat_parent, cat_name, alias, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description) "
                    . "VALUES (null,[site_id]," . (isset($store[Yii::app()->params['tables']['productcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['productcategory']][$nc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                    . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path']) . ","
                    . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . ");" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['productcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['productcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['productcategory'] . $nc['cat_id'];
        }
        $sql.="\n";
        //
        // Sản phẩm
        $products = Product::getAllProducts(array('limit' => 1000));
        foreach ($products as $pro) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['product'] . " (id, `name`, `code`, price, price_market, price_discount, price_discount_percent, include_vat, unit, quantity, `status`, position, product_sortdesc, product_desc, avatar_path, avatar_name, avatar_id, site_id, create_user, update_user, update_time, meta_keywords, meta_description, meta_title, list_product_relate, product_category_id, ishot, alias) "
                    . "VALUES (null," . ClaGenerate::quoteValue($pro['name']) . "," . ClaGenerate::quoteValue($pro['code']) . "," . $pro['price']
                    . "," . $pro['price_market'] . "," . $pro['price_discount'] . "," . $pro['price_discount_percent']
                    . "," . $pro['include_vat'] . "," . ClaGenerate::quoteValue($pro['unit']) . "," . $pro['quantity'] . "," . $pro['status'] . "," . $pro['position'] . ","
                    . ClaGenerate::quoteValue($pro['product_sortdesc']) . "," . ClaGenerate::quoteValue($pro['product_desc']) . "," . ClaGenerate::quoteValue($pro['avatar_path']) . "," . ClaGenerate::quoteValue($pro['avatar_name'])
                    . ",0,[site_id],[user_id],[user_id],[now],[now]," . ClaGenerate::quoteValue($pro['meta_keywords'])
                    . "," . ClaGenerate::quoteValue($pro['meta_description']) . "," . ClaGenerate::quoteValue($pro['meta_title']) . "," . ClaGenerate::quoteValue($pro['list_product_relate'])
                    . "," . (($pro['product_category_id']) ? "@" . $store[Yii::app()->params['tables']['productcategory']][$pro['product_category_id']]['map'] : $pro['product_category_id']) . "," . $pro['ishot']
                    . "," . ClaGenerate::quoteValue($pro['alias']) . ");" . "\n";
            //
            $sql.= "set @" . Yii::app()->params['tables']['product'] . $pro['id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['product']][$pro['id']]['map'] = Yii::app()->params['tables']['product'] . $pro['id'];
        }
        $sql.="\n";
        // Ảnh cho sản phẩm
        $productimages = Product::getAllImages();
        foreach ($productimages as $pi) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['productimage'] . " (img_id, product_id, `name`, path, display_name, description, alias, site_id, user_id, height, width, created_time, modified_time) "
                    . "VALUES (null,@" . $store[Yii::app()->params['tables']['product']][$pi['product_id']]['map'] . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                    . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                    . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                    . ");" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['productimage'] . $pi['img_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['productimage']][$pi['img_id']]['map'] = Yii::app()->params['tables']['productimage'] . $pi['img_id'];
        }
        $sql.="\n";
        // Cập nhật avatar_id for product
        foreach ($products as $pro) {
            if (!isset($store[Yii::app()->params['tables']['productimage']][$pro['avatar_id']]))
                continue;
            $sql.="UPDATE " . Yii::app()->params['tables']['product'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['productimage']][$pro['avatar_id']]['map']
                    . " WHERE id=@" . $store[Yii::app()->params['tables']['product']][$pro['id']]['map'] . ";\n";
        }
        //
        $sql.="\n\n";
        //
        // Trang nội dung
        $pagecategory = CategoryPage::getAllCategoryPage(array('limit' => 1000));
        foreach ($pagecategory as $pc) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['categorypage'] . " (id, title, content, site_id, user_id, alias, created_time, modified_time, modified_by) "
                    . "VALUES (null," . ClaGenerate::quoteValue($pc['title']) . "," . ClaGenerate::quoteValue($pc['content']) . ",[site_id],[user_id]"
                    . "," . ClaGenerate::quoteValue($pc['alias']) . ",[now],[now],[user_id]"
                    . ");" . "\n";
            $sql.= "set @" . Yii::app()->params['tables']['categorypage'] . $pc['id'] . " = LAST_INSERT_ID();" . "\n";
            $store[Yii::app()->params['tables']['categorypage']][$pc['id']]['map'] = Yii::app()->params['tables']['categorypage'] . $pc['id'];
        }
        $sql.="\n\n";
        //
        // video
        $videos = Videos::getVideoInSite(array('limit' => 100));
        if (count($videos)) {
            foreach ($videos as $video) {
                $sql.="INSERT INTO " . Yii::app()->params['tables']['video'] . " (video_id, site_id, user_id, video_title, video_description, video_link, video_embed, video_height, video_width, video_prominent, `status`, avatar_path, avatar_name, alias, order, meta_keywords, meta_description, keyword, created_time, modified_time) "
                        . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($pc['title']) . "," . ClaGenerate::quoteValue($pc['content']) . ",[site_id],[user_id]"
                        . "," . ClaGenerate::quoteValue($pc['alias']) . ",[now],[now],[user_id]"
                        . ");" . "\n";
                $sql.= "set @" . Yii::app()->params['tables']['categorypage'] . $pc['id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['video']][$pc['id']]['map'] = Yii::app()->params['tables']['categorypage'] . $pc['id'];
            }
            $sql.="\n\n";
        }
        // Menu group
        $menugroup = MenuGroups::getAllMenuGroup();
        foreach ($menugroup as $mg) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['menu_group'] . " (menu_group_id, menu_group_name, menu_group_description, site_id, user_id, config, created_time, modified_time, modified_by, menu_group_type) "
                    . "VALUES (null," . ClaGenerate::quoteValue($mg['menu_group_name']) . "," . ClaGenerate::quoteValue($mg['menu_group_description']) . ",[site_id],[user_id]"
                    . "," . ClaGenerate::quoteValue($mg['config']) . ",[now],[now],[user_id]," . $mg['menu_group_type']
                    . ");" . "\n";
            //
            $sql.= "set @" . Yii::app()->params['tables']['menu_group'] . $mg['menu_group_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu_group']][$mg['menu_group_id']]['map'] = Yii::app()->params['tables']['menu_group'] . $mg['menu_group_id'];
        }
        $sql.="\n";
        // Menu
        $menus = Menus::getAllMenuInSite(null, 'created_time');
        foreach ($menus as $menu) {
            $menu = Menus::prepareDataForBuild($menu);
            $sql.="INSERT INTO " . Yii::app()->params['tables']['menu'] . " (menu_id, site_id, user_id, menu_group, menu_title, parent_id, menu_linkto, menu_link, menu_basepath, menu_pathparams, menu_order, alias, `status`, menu_target, menu_values, created_time, modified_time, modified_by) "
                    . "VALUES (null,[site_id],[user_id],@" . $store[Yii::app()->params['tables']['menu_group']][$menu['menu_group']]['map'] . "," . ClaGenerate::quoteValue($menu['menu_title']) . "," . (isset($store[Yii::app()->params['tables']['menu']][$menu['parent_id']]) ? "@" . $store[Yii::app()->params['tables']['menu']][$menu['parent_id']]['map'] : 0)
                    . "," . $menu['menu_linkto'] . "," . ClaGenerate::quoteValue($menu['menu_link']) . ',' . ClaGenerate::quoteValue($menu['menu_basepath']) . "," . $menu['menu_pathparams']
                    . "," . $menu['menu_order'] . "," . ClaGenerate::quoteValue($menu['alias']) . "," . $menu['status'] . "," . $menu['menu_target']
                    . "," . $menu['menu_values'] . ",[now],[now],[user_id]"
                    . ");" . "\n";
            //
            $sql.= "set @" . Yii::app()->params['tables']['menu'] . $menu['menu_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu']][$menu['menu_id']]['map'] = Yii::app()->params['tables']['menu'] . $menu['menu_id'];
        }
        $sql.="\n\n";
        //
        // Menu Admin
        $menusadmin = MenusAdmin::getAllMenuInSite(null, 'created_time');
        foreach ($menusadmin as $menu) {
            $menu = MenusAdmin::prepareDataForBuild($menu);
            $sql.="INSERT INTO " . Yii::app()->params['tables']['menu_admin'] . " (menu_id, site_id, user_id, menu_title, parent_id, menu_linkto, menu_link, menu_basepath, menu_pathparams, menu_order, alias, `status`, menu_target, menu_values, iconclass, created_time, modified_time, modified_by) "
                    . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($menu['menu_title']) . "," . (isset($store[Yii::app()->params['tables']['menu_admin']][$menu['parent_id']]) ? "@" . $store[Yii::app()->params['tables']['menu_admin']][$menu['parent_id']]['map'] : 0)
                    . "," . $menu['menu_linkto'] . "," . ClaGenerate::quoteValue($menu['menu_link']) . ',' . ClaGenerate::quoteValue($menu['menu_basepath']) . "," . $menu['menu_pathparams']
                    . "," . $menu['menu_order'] . "," . ClaGenerate::quoteValue($menu['alias']) . "," . $menu['status'] . "," . $menu['menu_target']
                    . "," . ClaGenerate::quoteValue($menu['menu_values']) . "," . ClaGenerate::quoteValue($menu['iconclass']) . ",[now],[now],[user_id]"
                    . ");" . "\n";
            //
            $sql.= "set @" . Yii::app()->params['tables']['menu_admin'] . $menu['menu_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu_admin']][$menu['menu_id']]['map'] = Yii::app()->params['tables']['menu_admin'] . $menu['menu_id'];
        }
        $sql.="\n\n";
        // forms
        $forms = Forms::getAllForm();
        if (count($forms)) {
            foreach ($forms as $form) {
                $sql.="INSERT INTO " . Yii::app()->params['tables']['form'] . " (form_id, form_code, form_name, form_description, site_id, `status`, created_time, modified_time, user_id) "
                        . "VALUES (null," . ClaGenerate::quoteValue($form['form_code']) . "," . ClaGenerate::quoteValue($form['form_name']) . "," . ClaGenerate::quoteValue($form['form_description'])
                        . ",[site_id]," . $form['status'] . ",[now],[now],[user_id]"
                        . ");" . "\n";
                //
                $sql.= "set @" . Yii::app()->params['tables']['form'] . $form['form_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['form']][$form['form_id']]['map'] = Yii::app()->params['tables']['form'] . $form['form_id'];
            }
            $sql.="\n";
            $formsfields = FormFields::getFieldsInSite();
            $countfields = count($formsfields);
            if ($countfields) {
                $i = 0;
                $sql.="INSERT INTO " . Yii::app()->params['tables']['formfield'] . " (field_id, form_id, field_key, field_label, field_type, field_options, field_required, `order`, site_id, user_id, `status`) VALUES " . "\n";
                foreach ($formsfields as $ff) {
                    $i++;
                    $sql.="(null,@" . $store[Yii::app()->params['tables']['form']][$ff['form_id']]['map']
                            . ", " . ClaGenerate::quoteValue($ff['field_key']) . "," . ClaGenerate::quoteValue($ff['field_label']) . "," . ClaGenerate::quoteValue($ff['field_type'])
                            . "," . ClaGenerate::quoteValue($ff['field_options']) . "," . $ff['field_required'] . "," . $ff['order'] . ",[site_id],[user_id]," . $ff['status'] . ")"
                            . (($i == $countfields) ? ";" : ",") . "\n";
                }
            }
            $sql.="\n\n";
        }

        // module (page widget)
        $pagewidges = Widgets::getWidgets();
        foreach ($pagewidges as $pw) {
            $sql.="INSERT INTO " . Yii::app()->params['tables']['pagewidget'] . " (page_widget_id, site_id,user_id, widget_title, position, page_key, widget_type, widget_id, created_time, showallpage, worder) "
                    . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($pw['widget_title']) . "," . $pw['position']
                    . "," . ClaGenerate::quoteValue($pw['page_key']) . "," . $pw['widget_type'] . ',' . ClaGenerate::quoteValue($pw['widget_id']) . ",[now]," . $pw['showallpage'] . "," . $pw['worder']
                    . ");" . "\n";
            //
            $sql.= "set @" . Yii::app()->params['tables']['pagewidget'] . $pw['page_widget_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['pagewidget']][$pw['page_widget_id']]['map'] = Yii::app()->params['tables']['pagewidget'] . $pw['page_widget_id'];
        }
        $sql.="\n";
        // module config(page widget config)
        $pagewidgetconfigs = PageWidgetConfig::getAllPageWidgetConfigs();
        foreach ($pagewidgetconfigs as $pwc) {
            $pwc = PageWidgetConfig::prepareConfig($pwc, $pagewidges[$pwc['page_widget_id']]);
            $sql.="INSERT INTO " . Yii::app()->params['tables']['pagewidgetconfig'] . " (id, page_widget_id, site_id, user_id, config_data, created_time, modified_time) "
                    . "VALUES (null,@" . $store[Yii::app()->params['tables']['pagewidget']][$pwc['page_widget_id']]['map'] . ",[site_id],[user_id]," . $pwc['config_data'] . ",[now],[now]"
                    . ");" . "\n";
        }
        $sql.="\n";
        //
        $file = Yii::app()->theme->getBasePath() . '/' . 'data.sql';
        //echo $file;
        if (file_put_contents($file, $sql)) {
            @chmod($file, 0777);
            if ($sql) {
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Type: application/x-sql");
                header("Content-Disposition: attachment; filename=data.sql");
                header("Content-Transfer-Encoding: binary");
                //header("Content-Length: " . $filesize);
                echo $sql;
            }
            //die('success');
        }
        // --------------- end Banner
    }

    /**
     * Đặt web theo yêu cầu có trong theme
     */
    function actionOrder() {
        //
        if ($this->site_id != ClaSite::ROOT_SITE_ID)
            $this->sendResponse(404);
        //
        $theme_id = Yii::app()->request->getParam('theme');
        $theme = Themes::model()->findByPk($theme_id);
        //
        if (!$theme || $theme->status != Themes::STATUS_DEMO)
            $this->sendResponse(404);
        //
        $model = new Requests;
        //
        $theme_relaction = Themes::getThemeInRelaction($theme_id, array(
                    'cat_id' => $theme['category_id'],
                    'created_time' => $theme['created_time'],
        ));
        //
        $theme_relaction = ClaArray::getRandomInArray($theme_relaction, 3);
        //
        $this->render('order', array(
            'model' => $model,
            'theme' => $theme,
            'themerelaction' => $theme_relaction,
        ));
    }

    /**
     * Chỉ có web3nhat.com mới chạy được controller này
     * @param type $action
     */
    function beforeAction($action) {
        if ($action->id != 'generatesql') {
            if ($this->site_id . '' != ClaSite::ROOT_SITE_ID . '')
                $this->sendResponse(404);
        }
        //
        return true;
    }

}
