<?php

class BdsCompanyController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_company', 'company_manager') => Yii::app()->createUrl('/bds/bdsCompany'),
        );
        //
        $model = new BdsCompany('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['BdsCompany'])) {
            $model->attributes = $_GET['BdsCompany'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_company', 'company_manager') => Yii::app()->createUrl('/bds/bdsCompany'),
            Yii::t('bds_company', 'company_create') => Yii::app()->createUrl('/bds/bdsCompany/create'),
        );
        $model = new BdsCompany();

        $companyInfo = new BdsCompanyInfo();
        $companyInfo->site_id = $this->site_id;

        $post = Yii::app()->request->getPost('BdsCompany');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
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
                if (isset($_POST['BdsCompanyInfo'])) {
                    $companyInfo->attributes = $_POST['BdsCompanyInfo'];
                }
                $companyInfo->company_id = $model->id;
                $companyInfo->save();
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'companyInfo' => $companyInfo
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_company', 'company_manager') => Yii::app()->createUrl('/bds/bdsCompany'),
            Yii::t('bds_company', 'company_update') => Yii::app()->createUrl('/bds/bdsCompany/update'),
        );
        $model = $this->loadModel($id);

        $companyInfo = $this->loadModelInfo($id);

        $post = Yii::app()->request->getPost('BdsCompany');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
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
                if (isset($_POST['BdsCompanyInfo'])) {
                    $companyInfo->attributes = $_POST['BdsCompanyInfo'];
                }
                $companyInfo->company_id = $model->id;
                $companyInfo->save();
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'companyInfo' => $companyInfo
        ));
    }

    public function loadModel($id) {
        $model = BdsCompany::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

    public function loadModelInfo($id) {
        $model = BdsCompanyInfo::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

    public function actionDelete($id) {
        $company = $this->loadModel($id);
        $company->delete();
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
            $up->setPath(array($this->site_id, 'bdscompany', 'ava'));
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

    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new BdsCompany;
            $model->unsetAttributes();
            if (isset($_POST['BdsCompany'])) {
                $model->attributes = $_POST['BdsCompany'];
                if ($model->name && !$model->alias) {
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                }
            }
            if ($model->validate()) {
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

}
