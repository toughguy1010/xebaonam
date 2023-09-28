<?php

class RealestateNewsController extends PublicController {
    
    public $profileinfo = array();

    public $layout = 'real_estate_news';

    /**
     * real estate index
     */
    public function actionIndex() {
        //
        $this->layoutForAction = '//layouts/real_estate_index';
        //
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
        );
        $this->render('index');
    }

    // Tạo tin bất động sản
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('realestate', 'classifiedadvertising') => Yii::app()->createUrl('/news/realestateNews/create'),
        );

        $model = new RealEstateNews();
        $model->unsetAttributes();

        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_REAL_ESTATE;
        $category->generateCategory();

        $user_id = Yii::app()->user->id;
        
        
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        
        $this->profileinfo = ClaUser::getUserInfo($user_id);
        //
        if (!isset($this->profileinfo['site_id']) || $this->profileinfo['site_id'] != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (isset($_POST['RealEstateNews'])) {
            $model->attributes = $_POST['RealEstateNews'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->user_id = $user_id;
            $model->processPrice();

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            //
            if (!$model->getErrors()) {
                if ($model->save()) {
                    unset(Yii::app()->session[$model->avatar]);
                    Yii::app()->user->setFlash('success', Yii::t('realestate', 'create_realestate_news_success'));
                    $this->redirect(Yii::app()->createUrl('profile/profile/realestateNewsIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('create', array(
            'model' => $model,
            'category' => $category,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id
        ));
    }

    public function actionCategory($id) {
        $this->layoutForAction = '//layouts/real_estate_news';
        $category = RealEstateCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        $this->breadcrumbs = array(
            $category['cat_name'] => Yii::app()->createUrl('/news/realestateNews/category', array('id' => $category['cat_id'], 'alias' => $category['alias'])),
        );
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
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
            $category->cat_name => Yii::app()->createUrl('/content/realestateNews/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $list_realestate_news = RealEstateNews::getRealestateNewsInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RealEstateNews::countRealestateNewsInCate($id);
        $unit_price = RealEstateNews::unitPrice();
        //
        $this->render('category', array(
            'list_realestate_news' => $list_realestate_news,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'unit_price' => $unit_price
        ));
    }

    /**
     * trang chi tiết bất động sản
     */
    public function actionDetail($id) {
        $this->layoutForAction = '//layouts/real_estate_news';
        $realestate_news = RealEstateNews::model()->findByPk($id);
        if (!$realestate_news || $realestate_news['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($realestate_news['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $realestate_news['name'];
        //
        $user = Users::model()->findByPk($realestate_news->user_id);
        $category = RealEstateCategories::model()->findByPk($realestate_news['cat_id']);
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/news/realestateNews/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
            $realestate_news->name => Yii::app()->createUrl('/news/realestateNews/detail', array('id' => $realestate_news->id, 'alias' => $realestate_news->alias)),
        );
        $unit_price = RealEstateNews::unitPrice();
        $this->render('detail', array(
            'model' => $realestate_news,
            'user' => $user,
            'unit_price' => $unit_price
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'realestate_news', 'ava'));
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
     * rao vat
     */
    public function actionClassifiedAdvertising() {
        $this->layoutForAction = '//layouts/real_estate_advertising';
        $this->breadcrumbs = array(
            Yii::t('realestate', 'classifiedadvertising') => Yii::app()->createUrl('/news/realestate/classifiedAdvertising'),
        );
        $realestates = array();
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('real_estate'))
                ->where('status=:status AND site_id=:site_id AND type=:type', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':type' => ActiveRecord::TYPE_COMMERCIAL))
                ->order('created_time DESC')
                ->queryAll();
        if (count($data)) {
            foreach ($data as $p) {
                $realestates[$p['id']] = $p;
                $realestates[$p['id']]['link'] = Yii::app()->createUrl('news/realestate/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                $realestates[$p['id']]['full_address'] = $p['province_name'] . ' - ' . $p['district_name'];
            }
        }
        $this->render('classified_advertising', array(
            'realestates' => $realestates,
        ));
    }

}
