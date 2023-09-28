<?php

class PushupController extends BackController {

    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('pushup', 'pushup') => Yii::app()->createUrl('/setting/pushup'),
        );
        $modelFromDb = Pushup::model()->findByAttributes(array('type' => ClaPushup::type_onesignal, 'site_id' => $this->site_id));
        if (!$modelFromDb) {
            $modelFromDb = new Pushup();
            $modelFromDb->type = ClaPushup::type_onesignal;
        }
        $modelFromDb->site_id = $this->site_id;
        $model = new Push_Model_Onesignal('', array('model' => $modelFromDb));
        $model->site_id = $this->site_id;
        if (isset($_POST['Push_Model_Onesignal'])) {
            $model->attributes = $_POST['Push_Model_Onesignal'];
            $modelFromDb->options = json_encode($model->attributes);
            if ($modelFromDb->save()){
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect(Yii::app()->createUrl('/setting/pushup'));
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Maps the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $Maps = new Maps();
        $Maps->setTranslate(false);
        //
        $OldModel = $Maps->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Maps->setTranslate(true);
            $model = $Maps->findByPk($id);
            if (!$model) {
                $model = new Maps();
                $model->id = $id;
                $model->headoffice = $OldModel->headoffice;
                $model->latlng = $OldModel->latlng;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Maps $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'maps-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
