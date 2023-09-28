<?php

class BdsEquipmentController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_equipment', 'equipment_manager') => Yii::app()->createUrl('/bds/bdsEquipment'),
        );
        //
        $model = new BdsEquipment('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['BdsEquipment'])) {
            $model->attributes = $_GET['BdsEquipment'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_equipment', 'equipment_manager') => Yii::app()->createUrl('/bds/bdsEquipment'),
            Yii::t('bds_equipment', 'equipment_create') => Yii::app()->createUrl('/bds/bdsEquipment/create'),
        );
        $model = new BdsEquipment();
        $post = Yii::app()->request->getPost('BdsEquipment');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->showinlist = (isset($post["showinlist"]) && $post["showinlist"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }
        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_equipment', 'equipment_manager') => Yii::app()->createUrl('/bds/bdsEquipment'),
            Yii::t('bds_equipment', 'equipment_update') => Yii::app()->createUrl('/bds/bdsEquipment/update'),
        );
        $model = $this->loadModel($id);
        $post = Yii::app()->request->getPost('BdsEquipment');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->showinlist = (isset($post["showinlist"]) && $post["showinlist"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/bds/bdsEquipment"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = BdsEquipment::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

    public function actionDelete($id) {
        $equipment = $this->loadModel($id);
        $equipment->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
            $up->setPath(array($this->site_id, 'bdsequipments', 'ava'));
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
