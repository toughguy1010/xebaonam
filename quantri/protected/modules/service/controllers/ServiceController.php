<?php

class ServiceController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('service', 'service_manager') => Yii::app()->createUrl('service/service'),
            Yii::t('service', 'service_new') => Yii::app()->createUrl('/service/service/create'),
        );
        $model = new SeServices;
        $model->duration = ClaService::time_slot_length_default;
        $category_id = Yii::app()->request->getParam('cat');
        if ($category_id) {
            $model->category_id = $category_id;
        }
        $serviceInfo = new SeServicesInfo;
        $model->site_id = $serviceInfo->site_id = $this->site_id;
        if (isset($_POST['SeServices'])) {
            $model->attributes = $_POST['SeServices'];
//            if (!(int) $model->category_id) {
//                $model->category_id = 0;
//            }
            $categoryTrack = array_reverse($this->category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            if (isset($_POST['SeServicesInfo'])) {
                $serviceInfo->attributes = $_POST['SeServicesInfo'];
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
            if ($model->save()) {
                $serviceInfo->service_id = $model->id;
                $serviceInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/service/service'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'serviceInfo' => $serviceInfo,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'service_manager') => Yii::app()->createUrl('service/service'),
            Yii::t('service', 'service_edit') => Yii::app()->createUrl('/service/service/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $serviceInfo = $this->loadModelServiceInfo($id);
        if (isset($_POST['SeServices'])) {
            $model->attributes = $_POST['SeServices'];
//            if (!(int) $model->category_id) {
//                $model->category_id = 0;
//            }
            $categoryTrack = array_reverse($this->category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            if (isset($_POST['SeServicesInfo'])) {
                $serviceInfo->attributes = $_POST['SeServicesInfo'];
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
            if ($model->save()) {
                $serviceInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/service/service'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'serviceInfo' => $serviceInfo,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    public function actionIndex() {
        $model = new SeServices('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['SeServices']))
            $model->attributes = $_GET['SeServices'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SeServices the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $service = new SeServices();
        if (!$noTranslate) {
            $service->setTranslate(false);
        }
        //
        $OldModel = $service->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $service->setTranslate(true);
            $model = $service->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new SeServices();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        return $model;
    }

    public function loadModelServiceInfo($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $serviceInfo = new SeServicesInfo();
        if (!$noTranslate) {
            $serviceInfo->setTranslate(false);
        }
        //
        $OldModel = $serviceInfo->findByPk($id);
        //
        if (!$noTranslate && $language) {
            $serviceInfo->setTranslate(true);
            $model = $serviceInfo->findByPk($id);
            if (!$model) {
                $model = new SeServicesInfo();
                $model->service_id = $id;
                $model->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $model = $OldModel;
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeServices $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'se-services-form') {
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
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'services', 'ava'));
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

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_SERVICE;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    public function actionDeleteAvatar() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $service = $this->loadModel($id);
                if ($service) {
                    $service->image_path = '';
                    $service->image_name = '';
                    $service->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

}
