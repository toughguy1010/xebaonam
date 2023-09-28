<?php

class TourHotelGroupController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('tour_hotel', 'manager_hotel_group') => Yii::app()->createUrl('/tour/tourHotelGroup/'),
            Yii::t('tour_hotel', 'add_new') => Yii::app()->createUrl('/tour/tourHotelGroup/create'),
        );

        $this->setPageTitle('Tạo tập đoàn khách sạn');
        $model = new TourHotelGroup();

        $post = Yii::app()->request->getPost('TourHotelGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;

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
                $this->redirect(Yii::app()->createUrl("/tour/tourHotelGroup"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $this->breadcrumbs = array(
            Yii::t('tour_hotel', 'manager_hotel_group') => Yii::app()->createUrl('/tour/tourHotelGroup/'),
            Yii::t('tour_hotel', 'update') => Yii::app()->createUrl('/tour/tourHotelGroup/update'),
        );

        $this->setPageTitle('Tạo tập đoàn khách sạn');
        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('TourHotelGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;

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
                $this->redirect(Yii::app()->createUrl("/tour/tourHotelGroup"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $model = TourHotelGroup::model()->findByPk($id);
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
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour_hotel', 'manager_hotel_group') => Yii::app()->createUrl('/tour/tourHotelGroup'),
        );

        $model = new TourHotelGroup();
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CarCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CarCategories'])) {
            $model->attributes = $_GET['CarCategories'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CarCategories the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = TourHotelGroup::model()->findByPk($id);
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
     * @param CarCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
            $up->setPath(array($this->site_id, 'tour_hotel_group', 'ava'));
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
