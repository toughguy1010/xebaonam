<?php

class BdsEnvironmentController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_environment', 'environment_manager') => Yii::app()->createUrl('/bds/bdsEnvironment'),
        );
        //
        $model = new BdsEnvironment('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['BdsEnvironment'])) {
            $model->attributes = $_GET['BdsEnvironment'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_environment', 'environment_manager') => Yii::app()->createUrl('/bds/bdsEnvironment'),
            Yii::t('bds_environment', 'environment_create') => Yii::app()->createUrl('/bds/bdsEnvironment/create'),
        );
        $model = new BdsEnvironment();
        $post = Yii::app()->request->getPost('BdsEnvironment');
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
            Yii::t('bds_environment', 'environment_manager') => Yii::app()->createUrl('/bds/bdsEnvironment'),
            Yii::t('bds_environment', 'environment_update') => Yii::app()->createUrl('/bds/bdsEnvironment/update'),
        );
        $model = $this->loadModel($id);
        $post = Yii::app()->request->getPost('BdsEnvironment');
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
                $this->redirect(Yii::app()->createUrl("/bds/bdsEnvironment"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = BdsEnvironment::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

    public function actionDelete($id) {
        $environment = $this->loadModel($id);
        $environment->delete();
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
            $up->setPath(array($this->site_id, 'bdsenvironments', 'ava'));
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
