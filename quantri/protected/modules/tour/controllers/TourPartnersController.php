<?php

class TourPartnersController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'partner_manager') => Yii::app()->createUrl('/tour/tourPartners'),
        );
        //
        $model = new TourPartners('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['TourPartners'])) {
            $model->attributes = $_GET['TourPartners'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'partner_manager') => Yii::app()->createUrl('/tour/tourPartners'),
            Yii::t('tour', 'partner_create') => Yii::app()->createUrl('/tour/tourPartners/create'),
        );

        $model = new TourPartners();
        $post = Yii::app()->request->getPost('TourPartners');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;

            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/tour/tourPartners"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'partner_manager') => Yii::app()->createUrl('/tour/tourPartners'),
            Yii::t('tour', 'partner_create') => Yii::app()->createUrl('/tour/tourPartners/create'),
        );

        $model = TourPartners::model()->findByPk($id);
        $post = Yii::app()->request->getPost('TourPartners');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/tour/tourPartners"));
            }
        }

        $this->render('add', array(
            'model' => $model,
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
            $up->setPath(array($this->site_id, 'tourpartners', 'ava'));
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

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }

        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

   /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $object = new TourPartners();
        if (!$noTranslate) {
            $object->setTranslate(false);
        }
        //
        $OldModel = $object->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $object->setTranslate(true);
            $model = $object->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new News();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

}
