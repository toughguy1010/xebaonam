<?php

class AttachController extends BackController {

    /**
     * upload file
     */
    public function actionUpload() {
        $name = Yii::app()->request->getParam('name');
        if (!$name) {
            $name = 'files';
        }
        $file = $_FILES[$name];
        if (!$file) {
            $file = $_FILES['Filedata'];
        }
        if (isset($file) && $file) {
            $up = new UploadLib($file);
            $up->setPath(array('product', 'attach'));
            $up->uploadFile();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                Yii::app()->session[$keycode] = $response;
                $form = $this->renderPartial('attach_form', array(
                    'response' => $response,
                    'session' => $keycode,
                        ), true, true);
                $this->jsonResponse(200, array(
                    'form' => $form,
                ));
            }
            Yii::app()->end();
        }
        //
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            if ($model->site_id != $this->site_id)
                $this->jsonResponse(400);
            $model->delete();
            $this->jsonResponse(200);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $productFileModel = new ProductFiles();
        $productFileModel->setTranslate(false);
        //
        $OldModel = $productFileModel->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $productFileModel->setTranslate(true);
            $model = $productFileModel->findByPk($id);
            if (!$model) {
                $model = new ProductFiles();
                $model->attributes = $OldModel->attributes;
                $model->id = null;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function allowedActions() {
        return 'uploadfile,upload';
    }

}
