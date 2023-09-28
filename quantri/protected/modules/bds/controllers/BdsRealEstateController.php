<?php

class BdsRealEstateController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_real_estate', 'real_estate_manager') => Yii::app()->createUrl('/bds/bdsRealEstate'),
        );
        //
        $model = new BdsRealEstate('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['BdsRealEstate'])) {
            $model->attributes = $_GET['BdsRealEstate'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_real_estate', 'real_estate_manager') => Yii::app()->createUrl('/bds/bdsRealEstate'),
            Yii::t('bds_real_estate', 'real_estate_create') => Yii::app()->createUrl('/bds/bdsRealEstate/create'),
        );
        $model = new BdsRealEstate();
        
        $real_estateInfo = new BdsRealEstateInfo();
        $real_estateInfo->site_id = $this->site_id;
        
        $real_estate_map = new BdsMaps();
        $real_estate_map->site_id = $this->site_id;
        
        $post = Yii::app()->request->getPost('BdsRealEstate');
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
        $this->render('create', array(
            'model' => $model,
            'real_estateInfo' => $real_estateInfo,
            'real_estate_map' => $real_estate_map,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_real_estate', 'real_estate_manager') => Yii::app()->createUrl('/bds/bdsRealEstate'),
            Yii::t('bds_real_estate', 'real_estate_update') => Yii::app()->createUrl('/bds/bdsRealEstate/update'),
        );
        $model = $this->loadModel($id);
        $post = Yii::app()->request->getPost('BdsRealEstate');
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
                $this->redirect(Yii::app()->createUrl("/bds/bdsRealEstate"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = BdsRealEstate::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

    public function actionDelete($id) {
        $real_estate = $this->loadModel($id);
        $real_estate->delete();
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
            $up->setPath(array($this->site_id, 'bdsreal_estates', 'ava'));
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
