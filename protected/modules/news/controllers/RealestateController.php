<?php

class RealestateController extends PublicController {

    public $layout = '//layouts/real_estate';

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
        $this->layoutForAction = '//layouts/real_estate_create';
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/news/realestateProject/list'),
            Yii::t('common', 'create') => '',
        );
        $user_id = Yii::app()->user->id;
        $model = new RealEstate;
        $model->unsetAttributes();
        $model->type = 1;
        $option_project = RealEstateProject::getOptionProject();

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (isset($_POST['RealEstate'])) {
            $model->attributes = $_POST['RealEstate'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
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

            $model->user_id = $user_id;
            $model->status = 2;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('realestate', 'create_success'));
                    $this->redirect(array('create'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id
        ));
    }

    /**
     * trang chi tiết bất động sản
     */
    public function actionDetail($id) {
        //
        $this->layoutForAction = '//layouts/real_estate_detail';
        //
        $real_estate = RealEstate::model()->findByPk($id);
        if (!$real_estate) {
            $this->sendResponse(404);
        }
        if ($real_estate->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $project = array();
        if ($real_estate->project_id) {
            $project = RealEstateProject::model()->findByPk($real_estate->project_id);
        }

        //
        $this->pageTitle = $this->metakeywords = $real_estate->name;
        $this->metadescriptions = $real_estate->sort_description;

        if ($real_estate['image_path'] && $real_estate['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $real_estate['image_path'] . 's1000_1000/' . $real_estate['image_name'], 'og:image', null, array('property' => 'og:image'));
        }

        $user = Users::getCurrentUser();

        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $this->breadcrumbs = array(
            $project->name => Yii::app()->createUrl('/news/realestate/project', array('id' => $project->id, 'alias' => $project->alias)),
            $real_estate['name'] => '',
        );
        $unit_price = RealEstate::unitPrice();

        //
        $this->render('detail', array(
            'model' => $real_estate,
            'user' => $user,
            'unit_price' => $unit_price
        ));
    }

    public function actionProject($id) {
        $project = RealEstateProject::model()->findByPk($id);
        if (!$project) {
            $this->sendResponse(404);
        }
        if ($project->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $project->name;
        //
        $this->breadcrumbs = array(
            $project->name => Yii::app()->createUrl('/news/realestate/project', array('id' => $project->id, 'alias' => $project->alias)),
        );
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $list_realestate = RealEstate::getRealestateInProject($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RealEstate::countRealestateInProject($id);
        $unit_price = RealEstate::unitPrice();
        //
        $this->render('category', array(
            'list_realestate' => $list_realestate,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'project' => $project,
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
            $up->setPath(array($this->site_id, 'realestate', 'ava'));
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
