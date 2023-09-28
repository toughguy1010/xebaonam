<?php

class SupportController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'site_support') => Yii::app()->createUrl('setting/support'),
        );
        //
        $model = $this->loadModel($this->site_id);
        //
        if (isset($_POST['SiteSupport'])) {
            //
            $_data = Yii::app()->request->getPost('SiteSupport');
            $_data = $model->processData($_data);
            $data = array();
            if ($_data && is_array($_data)) {
                $styles = SiteSupport::getSupportTypesArr();
                foreach ($_data as $option) {
                    if (!isset($styles[$option['type']]))
                        continue;
                    array_push($data, $option);
                }
            }
            $model->data = $model->encodeData($data);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                $this->jsonResponse(200);
            }
            $this->jsonResponse(400);
        }
        //
        $this->render('index', array(
            'model' => $model,
            'data' => $model->processData($model->data),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteSupport the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $SiteSupport = new SiteSupport();
        $SiteSupport->setTranslate(false);
        //
        $OldModel = $SiteSupport->findByPk($id);
        //
        if ($OldModel === NULL) {
            $model = new SiteSupport();
            $model->site_id = $id;
        } else {
            if ($OldModel->site_id != $this->site_id)
                throw new CHttpException(404, 'The requested page does not exist.');
            if (ClaSite::getLanguageTranslate()) {
                $SiteSupport->setTranslate(true);
                $model = $SiteSupport->findByPk($id);
                if (!$model) {
                    $model = new SiteSupport();
                    $model->site_id = $id;
                }
            } else
                $model = $OldModel;
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SiteSupport $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'site-support-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
