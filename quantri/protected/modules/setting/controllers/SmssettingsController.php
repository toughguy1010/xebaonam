<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/14/2014
 */
class SmssettingsController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('sms', 'sms_manager') => Yii::app()->createUrl('setting/smssettings'),
            Yii::t('sms', 'sms_create') => Yii::app()->createUrl('/setting/smssettings/create'),
        );
        //
        $model = new SmsSettings;
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['SmsSettings'])) {
            $model->attributes = $_POST['SmsSettings'];
            // Add attributs code
            $akey = $_POST['akey'];
            $cakey = count($akey);
            $ades = $_POST['ades'];
            $attrs = array();
            if ($akey && $cakey) {
                for ($i = 0; $i < $cakey; $i++) {
                    if (trim($akey[$i])) {
                        if (!trim($ades[$i]))
                            $ades[$i] = '[' . $akey[$i] . ']';
                        $attrs[$akey[$i]] = $ades[$i];
                    }
                }
            }
            $model->sms_attributes = json_encode($attrs);
            if ($model->for_common) {
                $model->site_id = 0;
            }
            //Check key exist
            if ($model->findByPk($model->key))
                $model->addError('key', 'Key already exists');
            if (!$model->hasErrors()) {
                if ($model->save()) {
                    $this->redirect(array('index', 'id' => $model->key));
                } else {
                    var_dump($model->getErrors());
                    die;
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (!$model)
            return false;
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('sms', 'sms_manager') => Yii::app()->createUrl('setting/smssettings'),
            $model->title => Yii::app()->createUrl('/setting/smssettings/update', array('id' => $id)),
        );
        //
        if (isset($_POST['SmsSettings'])) {
            $model->attributes = $_POST['SmsSettings'];
            // Add attributs code
            $akey = $_POST['akey'];
            $cakey = count($akey);
            $ades = $_POST['ades'];
            $attrs = array();
            if ($akey && $cakey) {
                for ($i = 0; $i < $cakey; $i++) {
                    if (trim($akey[$i])) {
                        if (!trim($ades[$i]))
                            $ades[$i] = '[' . $akey[$i] . ']';
                        $attrs[$akey[$i]] = $ades[$i];
                    }
                }
            }
            $model->sms_attributes = json_encode($attrs);
            if (!$model->site_id && !$model->for_common) {
                $mailSetting = SmsSettings::model()->findByAttributes(array(
                    'key' => $model->key,
                    'site_id' => Yii::app()->controller->site_id,
                ));
                if ($mailSetting) {
                    if ($model->save()) {
                        $this->redirect(array('index', 'id' => $model->key));
                    }
                } else {
                    $tempModel = new SmsSettings();
                    $tempModel->attributes = $model->attributes;
                    $tempModel->site_id = Yii::app()->controller->site_id;
                    unset($tempModel->id);
                    $tempModel->save();
                    $this->redirect(array('index', 'id' => $tempModel->key));
                }
            } else {
                if ($model->site_id && $model->for_common) {
                    $mailSetting = SmsSettings::model()->findByAttributes(array(
                        'key' => $model->key,
                        'site_id' => 0,
                    ));
                    if ($mailSetting) {
                        $mailSetting->attributes = $_POST['SmsSettings'];
                        $mailSetting->mail_attribute = $model->mail_attribute;
                        $mailSetting->save();
                    }
                }
                //
                if ($model->save()) {
                    $this->redirect(array('index', 'id' => $model->key));
                }
            }
        }

        $this->render('update', array(
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
        if ($model->site_id != $this->site_id && $model->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * List all sms setting
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('sms', 'sms_manager') => Yii::app()->createUrl('setting/smssettings'),
        );
        //
        $model = new SmsSettings('search');
        $model->site_id = $this->site_id;
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SmsSettings']))
            $model->attributes = $_GET['SmsSettings'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SmsSettings the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SmsSettings::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $site_id = Yii::app()->controller->site_id;
        if ($model->site_id && $model->site_id != $site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SmsSettings $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sms-settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
