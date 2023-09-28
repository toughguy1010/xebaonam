<?php

class DestinationsController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $this->breadcrumbs = array(
            Yii::t('rent', 'destinations') => Yii::app()->createUrl('/economy/destinations/'),
            Yii::t('rent', 'add_destinations') => Yii::app()->createUrl('/economy/destinations/create'),
        );

        $this->setPageTitle(Yii::t('rent', 'add_destinations'));
        $model = new Destinations();

        $post = Yii::app()->request->getPost('Destinations');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;

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

            $model->site_id = $this->site_id;
            $model->showinhome = (isset($post["showinhome"]) && $post["showinhome"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            } else {
                $model->alias = HtmlFormat::parseToAlias($model->alias);
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/economy/destinations"));
            }
        }

        // get address options
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        $this->breadcrumbs = array(
            Yii::t('rent', 'destinations') => Yii::app()->createUrl('/economy/destinations/'),
            Yii::t('rent', 'update_destinations') => Yii::app()->createUrl('/economy/destinations/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);
        $post = Yii::app()->request->getPost('Destinations');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;

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

            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            } else {
                $model->alias = HtmlFormat::parseToAlias($model->alias);
            }
            $model->site_id = $this->site_id;
            $model->showinhome = (isset($post["showinhome"]) && $post["showinhome"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/economy/destinations"));
            }
        }

        // get address options
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        $model = Destinations::model()->findByPk($id);
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
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('rent', 'destinations') => Yii::app()->createUrl('/economy/destinations'),
        );

        $model = new Destinations('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Destinations('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Destinations'])) {
            $model->attributes = $_GET['Destinations'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Destinations the loaded model
     * @throws CHttpException
     */

    public function loadModel($id)
    {
        $model = Destinations::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != Yii::app()->controller->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Destinations $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tour-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
            $up->setPath(array($this->site_id, 'destinations', 'ava'));
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
