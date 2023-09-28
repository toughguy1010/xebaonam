<?php

class RealestateNewsController extends BackController {

    /**
     * Index
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'classifiedadvertising_manager') => Yii::app()->createUrl('/content/realestateNews/'),
        );
        //
        $model = new RealEstateNews();
        //
        $this->render("index", array(
            'model' => $model,
        ));
    }

    /**
     * Edit news category
     * @param type $id
     */
    public function actionUpdate($id) {
        $model = RealEstateNews::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestateNews/'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/realestateNews/update', array('id' => $id)),
        );

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_REAL_ESTATE;
        $category->generateCategory();

        $user_id = Yii::app()->user->id;

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
                    $this->redirect(array('index'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('add', array(
            'model' => $model,
            'category' => $category,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
        ));
    }

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
                    $this->redirect(array('index'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('add', array(
            'model' => $model,
            'category' => $category,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id
        ));
    }

    //
    public function actionDelete($id) {
        $model = RealEstateNews::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
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

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $realestatenews = new RealEstateNews();
        $realestatenews->setTranslate(false);
        //
        $OldModel = $realestatenews->findByPk($id);
        return $OldModel;
    }

    //
}
