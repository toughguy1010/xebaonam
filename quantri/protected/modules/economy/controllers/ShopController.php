<?php

class ShopController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('shop', 'shop_manager') => Yii::app()->createUrl('/economy/shop'),
        );
        //
        $model = new Shop('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Shop'])) {
            $model->attributes = $_GET['Shop'];
        }
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //
        $this->breadcrumbs = array(
            Yii::t('shop', 'shop_manager') => Yii::app()->createUrl('/economy/shop'),
            Yii::t('shop', 'update') => Yii::app()->createUrl('/economy/shop/update'),
        );

        $model = Shop::model()->findByPk($id);
        
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
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            if (!$model->getErrors()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('shop', 'update_success'));
                    $this->redirect(array('index'));
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

        $this->render('update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'categories' => $categories
        ));
    }

    public function actionDelete($id) {
        $model = Shop::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
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

}

?>