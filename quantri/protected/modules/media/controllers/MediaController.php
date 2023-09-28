<?php

/**
 * @author hungtm
 */
class MediaController extends BackController {

    /**
     * update picture
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('contact', 'site_contact_form') => Yii::app()->createUrl('/media/media/'),
            Yii::t('common', 'update') => Yii::app()->createUrl('/media/album/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['SiteContactForm'])) {

            $model->attributes = $_POST['SiteContactForm'];
            $file = $_FILES['image_src'];
            if ($file && $file['name']) {
                $model->image_src = 'true';
                $extensions = SiteContactForm::allowExtensions();

                if (!isset($extensions[$file['type']])) {
                    $model->addError('image_src', Yii::t('banner', 'banner_invalid_format'));
                }
            }
            if (!$model->getErrors()) {
                if ($file && $file['name']) {
                    $up = new UploadLib($file);
                    $up->setPath(array($this->site_id, 'print_image'));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    //
                    if ($up->getStatus() == '200') {
                        $model->image_src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    } else {
                        $model->image_src = '';
                    }
                }
                //
                if ($model->save()) {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('add_edit', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            return false;
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = Images::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);

            if ($image->delete())
                $this->jsonResponse(200);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('contact', 'site_contact_form') => Yii::app()->createUrl('/media/media/'),
        );
        //
        $model = new SiteContactForm('search');

        $model->unsetAttributes();  // clear any default values

        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Albums the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $images = new SiteContactForm();
        $images->setTranslate(false);
        //
        $OldModel = $images->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $images->setTranslate(true);
            $model = $images->findByPk($id);
        } else {
            $model = $OldModel;
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Albums $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'albums-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
