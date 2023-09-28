<?php

class AppointmentController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'appointment_manager') => Yii::app()->createUrl('service/appointment'),
            Yii::t('service', 'appointment_create') => Yii::app()->createUrl('service/appointment/create'),
        );
        //
        $model = new SeAppointments;
        if (isset($_POST['SeAppointments'])) {
            $model->attributes = $_POST['SeAppointments'];
            $model->date = date('Y-m-d', strtotime($model->date));
            if ($model->save()) {
                $ProviderService = SeProviderServices::model()->findByAttributes(array(
                    'site_id' => $this->site_id,
                    'provider_id' => $model->provider_id,
                    'service_id' => $model->service_id,
                ));
                if ($ProviderService && $ProviderService->price) {
                    $model->total = floatval($ProviderService->price);
                } else {
                    $service = SeServices::model()->findByPk($model->service_id);
                    if ($service) {
                        $model->total = floatval($service->price);
                    }
                }
                $model->save();
                $this->redirect(Yii::app()->createUrl('service/appointment'));
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
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'appointment_manager') => Yii::app()->createUrl('service/appointment'),
            Yii::t('service', 'appointment_update') => Yii::app()->createUrl('service/appointment/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        //
        if (isset($_POST['SeAppointments'])) {
            $post = $_POST['SeAppointments'];
            if(isset($post['total'])){
                unset($post['total']);
            }
            $model->attributes = $_POST['SeAppointments'];
            $model->date = date('Y-m-d', strtotime($model->date));
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('service/appointment'));
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
        if ($model->site_id != $this->site_id && !ClaUser::isSupperAdmin()) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
                    if ($model->site_id == $this->site_id || ClaUser::isSupperAdmin()) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'appointment_manager') => Yii::app()->createUrl('service/appointment'),
        );
        //
        $model = new SeAppointments('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['SeAppointments'])) {
            $model->attributes = $_GET['SeAppointments'];
        }
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * dash board
     */
    function actionDashboard() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'appointment_manager') => Yii::app()->createUrl('service/appointment'),
            Yii::t('service', 'appointment_dashboard') => Yii::app()->createUrl('service/appointment/dashboard'),
        );
        //
        $providerActive = Yii::app()->request->getParam(ClaService::query_provider_key, '');
        $poptions = array();
        $providers = SeProviders::getProviders($poptions);
        //
        $timeType = Yii::app()->request->getParam('ttype', 'month');
        $time = Yii::app()->request->getParam('time', (int) date('m'));
        $year = (int) date('Y');
        //
        $params = array(
            ClaService::query_provider_key => $providerActive,
        );
        if ($timeType) {
            $params['ttype'] = $timeType;
        }
        if ($time) {
            $params['time'] = $time;
        }
        //
        $aoptions = array(
            'provider_id' => $providerActive,
        );
        switch ($timeType) {
            case 'month': {
                    $month = ((int) $time) ? (int) $time : (int) date('m');
                    $time = $month;
                    $aoptions['dateFrom'] = $year . '-' . $month . '-1';
                    $dayofMonth = ClaDateTime::get_days_in_month($month, $year);
                    $aoptions['dateTo'] = $year . '-' . $month . '-' . $dayofMonth;
                }break;
        }
        //
        $aoptions['order'] = 'date, created_time DESC';
        $appointments = SeAppointments::getAppointments($aoptions);
        $appointments = $this->processAppointment($appointments,$timeType);
        //
        $this->render('calendar', array(
            'appointments' => $appointments,
            'providers' => $providers,
            'provider_id' => $providerActive,
            'timeType' => $timeType,
            'time' => $time,
            'year' => $year,
            'params' => $params,
        ));
    }

    /**
     * 
     */
    function processAppointment($appointments = array(), $type = 'month') {
        $data = array();
        switch ($type) {
            case 'month': {
                    foreach($appointments as $appoint){
                        $data[$appoint['date']][$appoint['id']] = $appoint;
                    }
                }break;
        }
        return $data;
    }

    /**
     *
     * @param type $id
     * @param type $noTranslate
     * @return type
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $appointment = new SeAppointments();
        if (!$noTranslate) {
            $appointment->setTranslate(false);
        }
        //
        $OldModel = $appointment->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id && $this->site_id != ClaSite::ROOT_SITE_ID) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $appointment->setTranslate(true);
            $model = $appointment->findByPk($id);
            if ($model && $model->site_id != $this->site_id && $this->site_id != ClaSite::ROOT_SITE_ID) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new SeAppointments();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeAppointments $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'se-appointments-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
