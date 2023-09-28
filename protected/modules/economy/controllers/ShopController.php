<?php

class ShopController extends PublicController
{

    public $layout = '//layouts/admin_column2';

    /**
     * Show ra danh sách gian hàng
     */
    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/shop';
        //

        $this->breadcrumbs = array(
            Yii::t('shop', 'shop') => Yii::app()->createUrl('/economy/shop'),
        );
        $this->render('index');
    }

    /**
     * Quản lý khách hàng yêu thích gian hàng
     */
    public function actionCustomerLike()
    {
        //
        $this->layoutForAction = '//layouts/admin_column2';
        //

        $this->breadcrumbs = array(
            Yii::t('shop', 'manager_customer_like') => Yii::app()->createUrl('/economy/shop/customerLike'),
        );
        //
        $current_shop = Shop::getCurrentShop();
        $model = new Likes('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Likes'])) {
            $model->attributes = $_GET['Likes'];
        }
        $model->object_id = $current_shop['id'];
        $model->type = Likes::TYPE_SHOP;
        $model->site_id = $this->site_id;

        $this->render('customer_like', array(
            'model' => $model
        ));
    }

    public function actionDetail($id)
    {
        //
        $this->layoutForAction = '//layouts/shop_detail';
        //
        $shop = Shop::model()->findByPk($id);
        if (!$shop) {
            $this->sendResponse(404);
        }
        if ($shop->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $shop->name;
        $this->metadescriptions = $shop->name;
        if (isset($shop->meta_keywords) && $shop->meta_keywords) {
            $this->metakeywords = $shop->meta_keywords;
        }
        if (isset($shop->meta_description) && $shop->meta_description) {
            $this->metadescriptions = $shop->meta_description;
        }
        if (isset($shop->meta_title) && $shop->meta_title) {
            $this->metaTitle = $shop->meta_title;
        }
        $this->breadcrumbs [$shop['name']] = Yii::app()->createUrl('/economy/shop/detail', array('id' => $shop['id'], 'alias' => $shop['alias']));
        //        
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR) ? Yii::app()->request->getParam(ClaSite::PAGE_VAR) : 1;
        $order = 'id DESC';
        //
        $cid = Yii::app()->request->getParam('cid', 0);
        $products = Product::getProductsInShop($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'cid' => $cid,
        ));
        //
        $totalitem = Product::countProductsInShop($id);

        $this->render('detail', array(
            'products' => $products,
            'shop' => $shop->attributes,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    public function actionSearchShop()
    {

        $model = new Shop();
        $model->unsetAttributes();

        if (isset($_POST['Shop'])) {

            $model->attributes = $_POST['Shop'];
            $model->status = 1;
            $criteria = new CDbCriteria;
            $criteria->compare('id', $model->id, true);
            $criteria->compare('name', $model->name, true);
            $criteria->compare('alias', $model->alias, true);
            $criteria->compare('user_id', $model->user_id);
            $criteria->compare('address', $model->address, true);
            $criteria->compare('province_id', $model->province_id, true);
            $criteria->compare('province_name', $model->province_name, true);
            $criteria->compare('district_id', $model->district_id, true);
            $criteria->compare('district_name', $model->district_name, true);
            $criteria->compare('ward_id', $model->ward_id, true);
            $criteria->compare('ward_name', $model->ward_name, true);
            $criteria->compare('image_path', $model->image_path, true);
            $criteria->compare('image_name', $model->image_name, true);
            $criteria->compare('phone', $model->phone, true);
            $criteria->compare('email', $model->email, true);
            $criteria->compare('yahoo', $model->yahoo, true);
            $criteria->compare('skype', $model->skype, true);
            $criteria->compare('website', $model->website, true);
            $criteria->compare('field_business', $model->field_business, true);
            $criteria->compare('status', $model->status);
            $criteria->compare('created_time', $model->created_time);
            $criteria->compare('modified_time', $model->modified_time);

            $dataProvider = new CActiveDataProvider($model, array(
                'criteria' => $criteria,
            ));

        }

        $listprovince = LibProvinces::getListProvinceArr();
        array_unshift($listprovince, Yii::t('common', 'choose_province'));
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        array_unshift($listdistrict, Yii::t('common', 'choose_district'));
        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }
        array_unshift($listward, Yii::t('common', 'choose_ward'));
        $this->render('search', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
        ));
    }

    /**
     * Shop create
     */
    public function actionCreate()
    {
        //
        $user_id = Yii::app()->user->id;
        if (!$user_id) {
            $this->redirect(Yii::app()->createUrl('login/login/login'));
        }
        $this->breadcrumbs = array(
            Yii::t('shop', 'create') => Yii::app()->createUrl('/economy/shop/create'),
        );
        $current_shop = Shop::getCurrentShop();
        if ($current_shop) {
            $this->redirect(Yii::app()->createUrl('economy/shop/update', array('id' => $current_shop['id'])));
        }
        $model = new Shop();
        $model->unsetAttributes();

        $model->allow_number_cat = 3;
        $model->status = 2; // chờ duyệt
        $model->time_open = 7; // default: 7h sáng
        $model->time_close = 22; // default: 22h tối
        $model->day_open = 2; // default: thứ 2
        $model->day_close = 8; // default: chủ nhật
        $model->type_sell = 1; // Có địa chỉ
        if (isset($_POST['Shop'])) {
            $model->attributes = $_POST['Shop'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->image) {
                $image = Yii::app()->session[$model->image];
                if (!$image) {
                    $model->image = '';
                } else {
                    $model->image_path = $image['baseUrl'];
                    $model->image_name = $image['name'];
                }
            }

            $model->user_id = Yii::app()->user->id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    unset(Yii::app()->session[$model->avatar]);
                    unset(Yii::app()->session[$model->image]);

                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $recount = 0;
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ShopImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->shop_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }

                    // gửi email để thông báo cho chủ site có gian hàng đăng ký 
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'noticeshopnew',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'shop_name' => $model->name,
                        );
                        $content = $mailSetting->getMailContent($data);
                        $subject = $mailSetting->getMailSubject($data);
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_waiting_actived'));

                    Yii::app()->user->setFlash('success', Yii::t('shop', 'create_success'));
                    $this->redirect(Yii::app()->createUrl('economy/shop/update', array('id' => $model->id)));
                }
            }
        }

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }

        $this->render('add', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'shop', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    /**
     * upload file
     */
    public function actionUploadfileimage()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'shop', 'image'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['image'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function actionUpdate($id)
    {
        //
        $this->breadcrumbs = array(
            Yii::t('shop', 'update') => Yii::app()->createUrl('/economy/shop/update'),
        );
        $user_id = Yii::app()->user->id;
        if (!$user_id) {
            $this->redirect(Yii::app()->createUrl('login/login/login'));
        }
        $model = Shop::model()->findByPk($id);
        if ($model === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->user_id != $user_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $categories = ProductCategories::getCategoriesByParentid(ClaCategory::CATEGORY_ROOT);

        if (isset($_POST['Shop'])) {
            $model->attributes = $_POST['Shop'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $ward = LibWards::model()->findByPk($model->ward_id);
            if ($ward) {
                $model->ward_name = $ward->name;
            }

            $model->user_id = Yii::app()->user->id;
            if (isset($_POST['ShopCategory'])) {
                $shop_categories = $_POST['ShopCategory'];
            }
            if (!$model->getErrors()) {
                if ($model->save()) {

                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $shop_avatar = array();
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ShopImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->shop_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $shop_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $shop_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        //
                        // update avatar of shop
                        if ($shop_avatar && count($shop_avatar)) {
                            $model->image_path = $shop_avatar['path'];
                            $model->image_name = $shop_avatar['name'];
                            $model->avatar_id = $shop_avatar['img_id'];
                            //
                            $model->save();
                        }
                    }

                    if (isset($shop_categories) && count($shop_categories)) {
                        $model->saveProductCategory($shop_categories);
                    }
                    Yii::app()->user->setFlash('success', Yii::t('shop', 'update_success'));
                }
            }
        }

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }

        $this->render('add', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'categories' => $categories
        ));
    }

    public function actionDelimage($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ShopImages::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            $shop = Shop::model()->findByPk($image->shop_id);
            if ($image->delete()) {
                if ($shop->avatar_id == $image->img_id) {
                    $navatar = $shop->getFirstImage();
                    if (count($navatar)) {
                        $shop->avatar_id = $navatar['img_id'];
                        $shop->image_path = $navatar['path'];
                        $shop->image_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $shop->avatar_id = '';
                        $shop->image_path = '';
                        $shop->image_name = '';
                    }
                    $shop->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    public function actionCategory($id)
    {
        $this->layoutForAction = '//layouts/shop';

        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/economy/shop/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }

        $filter_shop = isset(Yii::app()->session[Shop::FILTER_SHOP]) ? Yii::app()->session[Shop::FILTER_SHOP] : array();
        $category = ProductCategories::model()->findByPk($id);

        $shop_id = Yii::app()->db->createCommand()->select('shop_id')
            ->from(ClaTable::getTable('shop_product_category'))
            ->where('cat_id=:cat_id', array(':cat_id' => $id))
            ->queryColumn();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'id DESC';
        $limit = Shop::SHOP_DEFAUTL_LIMIT;
        $shops = Shop::getAllshops(array(
                'limit' => $limit,
                ClaSite::PAGE_VAR => $page,
                'order' => $order,
                'ids' => join(',', $shop_id)
            )
        );
        $totalitem = count($shops);
        $this->render('category', array(
            'shops' => $shops,
            'limit' => $limit,
            'totalitem' => $totalitem,
            'filter_shop' => $filter_shop,
        ));
    }

    /**
     * @author: hungtm
     * function này sẽ lưu session id thành phố, quận, huyện
     * toàn bộ site sẽ query theo session này
     */
    public function actionFilterAddress()
    {
        if (isset($_POST['Shop'])) {
            $data = $_POST['Shop'];
            $conditions = '';
            if (isset($data['province_id']) && $data['province_id']) {
                Yii::app()->session['province_id'] = $data['province_id'];
            }
            if (isset($data['district_id']) && $data['district_id']) {
                Yii::app()->session['district_id'] = $data['district_id'];
            }
            if (isset($data['ward_id']) && $data['ward_id']) {
                Yii::app()->session['ward_id'] = $data['ward_id'];
            }
            $this->redirect(Yii::app()->getBaseUrl(true));
        }
    }

    // like shop sàn thời trang
    public function actionLikeshop()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $status = Yii::app()->request->getParam('status', 'like');

        if ($id) {
            if ($status == 'like') {
                $model = new Likes();
                $model->object_id = $id;
                $model->user_id = Yii::app()->user->id;
                $model->type = Likes::TYPE_SHOP;
                $model->site_id = Yii::app()->controller->site_id;
                $model->created_time = time();
                if ($model->save()) {
                    $srcimg = Yii::app()->theme->baseUrl . '/css/img/icon-like2.png';
                    $this->jsonResponse(200, array('srcimg' => $srcimg, 'status' => 'like', 'count_like' => Likes::countLikedshop($id, Likes::TYPE_SHOP)));
                }
            } else if ($status == 'unlike') {
                $model = Likes::model()->findByAttributes(array(
                    'object_id' => $id,
                    'user_id' => Yii::app()->user->id,
                    'type' => Likes::TYPE_SHOP
                ));
                if ($model->delete()) {
                    $srcimg = Yii::app()->theme->baseUrl . '/css/img/icon-like1.png';
                    $this->jsonResponse(200, array('status' => 'unlike', 'srcimg' => $srcimg, 'count_like' => Likes::countLikedshop($id, Likes::TYPE_SHOP)));
                }
            }
        } else {
            $this->jsonResponse(404);
        }
    }

    public function actionSetFilterShop()
    {
        $type_filter = Yii::app()->request->getParam('type_filter', 0);
        $execute_filter = Yii::app()->request->getParam('execute_filter', 0);
        if ($type_filter) {
            $array_session = isset(Yii::app()->session[Shop::FILTER_SHOP]) ? Yii::app()->session[Shop::FILTER_SHOP] : array();
            if (in_array($type_filter, $array_session) && !$execute_filter) {
                unset($array_session[$type_filter]);
            } else {
                $array_session[$type_filter] = $type_filter;
            }
            Yii::app()->session->add(Shop::FILTER_SHOP, $array_session);
            $this->jsonResponse(200, array(
                'type_filter' => $type_filter,
                'execute_filter' => $type_filter,
                'array_session' => $array_session,
            ));
        } else {
            $this->jsonResponse(404);
        }
    }

    public function actionStore()
    {
        //
        $this->layoutForAction = '//layouts/store';
        //
        $this->breadcrumbs = array(
            Yii::t('shop', 'store') => Yii::app()->createUrl('/economy/shop/store'),
        );

        $this->pageTitle = Yii::t('shop', 'store');
        
        $province = Yii::app()->request->getParam('province', 0);
        $district = Yii::app()->request->getParam('district', 0);
        $ward = Yii::app()->request->getParam('ward', 0);
        $level = Yii::app()->request->getParam('level', 0);

        $stores = ShopStore::getAllShopstore([
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'level' => $level
        ]);
        $listGroup = ShopStore::listGroup();
        $this->render('store', array(
            'stores' => $stores,
            'listGroup' => $listGroup,
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'level' => $level
        ));
    }

    public function actionStoreWithMap()
    {
        //
        $this->layoutForAction = '//layouts/store';
        //
        $this->breadcrumbs = array(
            Yii::t('shop', 'store') => Yii::app()->createUrl('/economy/shop/store'),
        );

        $this->pageTitle = Yii::t('shop', 'store');

        $stores = ShopStore::getAllShopstore();
        $listGroup = ShopStore::listGroup();
        $this->registerClientScript();

        $this->render('store_with_map', array(
            'stores' => $stores,
            'listGroup' => $listGroup,
        ));
    }

    /**
     * Function get store by group
     * @param $group_id
     * @return mixed
     */
    public function registerClientScript()
    {
        $map_api_key = SiteSettings::model()->findByPk(Yii::app()->controller->site_id)['map_api_key'];
        if (!Yii::app()->request->isAjaxRequest) {
            if (!defined("REGISTERSCRIPT_MAP")) {
                define("REGISTERSCRIPT_MAP", true);
                $client = Yii::app()->clientScript;
                if (isset($map_api_key) && $map_api_key) {
                    $url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . $map_api_key;
                } else {
                    $url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places';
                }
                $client->registerScriptFile($url);
            }
        }
    }

    /**
     * Function get store by group
     * @param $group_id
     * @return mixed
     */
    public function actionGetStoreByGroup($group_id)
    {
        $stores = ShopStore::getShopByGroup($group_id);
        if ($stores) {
            return $this->jsonResponse(200, array(
                'stores' => $stores));
        }
    }

    /**
     * Get Store Detail
     * @param $id
     */
    public function actionStoreDetail($id)
    {
        //
        $this->layoutForAction = '//layouts/store';
        $store = ShopStore::model()->findByPk($id);
        //
        $this->breadcrumbs = array(
            Yii::t('shop', 'store') => Yii::app()->createUrl('/economy/shop/store'),
            $store->name => Yii::app()->createUrl('/economy/shop/storedetail', array('id' => $id)),
        );

        $this->pageTitle = $store->name;

        $this->metakeywords = $this->metaTitle = $this->pageTitle = $store->name;
        $this->metadescriptions = $store->name;

        if (isset($store->meta_keywords) && $store->meta_keywords) {
            $this->metakeywords = $store->meta_keywords;
        }
        if (isset($store->meta_description) && $store->meta_description) {
            $this->metadescriptions = $store->meta_description;
        }
        if (isset($store->meta_title) && $store->meta_title) {
            $this->metaTitle = $store->meta_title;
        }
        $this->registerClientScript();

        $this->render('store_detail', array(
            'store' => $store,
        ));
    }

    public function actionAddaddress()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $count_address = Yii::app()->request->getParam('count_address', 0);

            $listprovince = LibProvinces::getListProvinceArr();
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;

            $listdistrict = false;
            if (!$listdistrict) {
                $listdistrict = LibDistricts::getListDistrictArrFollowProvince($firstpro);
            }
            $firstd = array_keys($listdistrict);
            $firstdis = isset($firstd[0]) ? $firstd[0] : null;

            $listward = false;
            if (!$listward) {
                $listward = LibWards::getListWardArrFollowDistrict($firstdis);
            }
            $html = $this->renderPartial('addaddress', array(
                'count_address' => $count_address,
                'listprovince' => $listprovince,
                'listdistrict' => $listdistrict,
                'listward' => $listward,
            ), true);
            $this->jsonResponse(200, array(
                'html' => $html
            ));
        }
    }

    /**
     * @hungtm
     * Gian hàng tự tạo danh mục
     */
    public function actionCreateCategory()
    {
        $model = new ShopCatSelf();

        $post = Yii::app()->request->getPost('ShopCatSelf');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->shop_id = 5;
            if ($model->save()) {
                $this->redirect(array('indexCategory'));
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $this->render('addcatself', array(
            'model' => $model,
            'option' => $option
        ));
    }

    /**
     * @hungtm
     * Danh sách danh mục sản phẩm của gian hàng
     */
    public function actionIndexCategory()
    {
        $model = new ShopCatSelf();

        $this->render('indexcatself', array(
            'model' => $model
        ));
    }

}

?>