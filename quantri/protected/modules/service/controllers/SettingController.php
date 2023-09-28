<?php

class SettingController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'setting') => Yii::app()->createUrl('service/setting'),
        );
        //
        $sitesetting = new SiteSettings();
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        if (!$model) {
            $this->sendResponse(404);
        }
        $seSetting = isset($model['se_settings']) ? $model['se_settings'] : '';
        $seSetting = json_decode($seSetting, true);
        //
        $GeneralModel = new GeneralModel();
        $GeneralModel->attributes = $seSetting;
        if(!$GeneralModel->time_slot_length){
            $GeneralModel->time_slot_length = ClaService::time_slot_length_default;
        }
        //
        $businessHours = ClaService::getBusinessHours();
        //
        $this->render('index', array(
            'GeneralModel' => $GeneralModel,
            'businessHours' => $businessHours,
        ));
    }

    /**
     * save general setting
     */
    public function actionGeneral() {
        if (Yii::app()->request->isAjaxRequest) {
            $GeneralModel = new GeneralModel();
            $GeneralModel->attributes = $_POST['GeneralModel'];
            if ($GeneralModel->validate()) {
                $site_id = Yii::app()->controller->site_id;
                $model = $this->loadModel($site_id);
                $seSetting = isset($model['se_settings']) ? $model['se_settings'] : '';
                $seSetting = json_decode($seSetting, true);
                if (!$seSetting) {
                    $seSetting = array();
                }
                $seSetting = array_merge($seSetting, $GeneralModel->attributes);
                //
                $model->se_settings = json_encode($seSetting);
                $model->save();
                //
                $this->jsonResponse(200, array(
                    'message' => Yii::t('common', 'updatesuccess'),
                ));
            }
        }
    }

    /*
     * save bussiness hours
     */

    public function actionBusinesshours() {
        if (Yii::app()->request->isAjaxRequest) {
            $businessHours = $_POST['BusinessHours'];
            $businessHoursDefault = ClaService::getBusinessHourDefault();
            $keys = array_keys($businessHours);
            $keysDefault = array_keys($businessHoursDefault);
            $diff = array_diff($keys, $keysDefault);
            if ($diff || count($keys) != count($keysDefault)) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            //
            $error = false;
            foreach ($businessHours as $dayindex => $hour) {
                if (!isset($hour['start_time']) || !isset($hour['end_time'])) {
                    $error = true;
                    break;
                }
                if ($hour['start_time'] == 0 || $hour['end_time'] == 0) {
                    $businessHours[$dayindex]['start_time'] = $businessHours[$dayindex]['end_time'] = 0;
                }
                if ((int) $hour['start_time'] > $hour['end_time']) {
                    $error = true;
                    break;
                }
                if ((int) $hour['start_time'] > ClaService::max_time_length || (int) $hour['end_time'] > ClaService::max_time_length) {
                    $error = true;
                    break;
                }
                $businessHours[$dayindex]['day_index'] = $dayindex;
            }
            if ($error) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            //
            $site_id = Yii::app()->controller->site_id;
            $model = $this->loadModel($site_id);
            $seSetting = isset($model['se_settings']) ? $model['se_settings'] : '';
            $seSetting = json_decode($seSetting, true);
            if (!$seSetting) {
                $seSetting = array();
            }
            $seSetting['business_hours'] = $businessHours;
            //
            $model->se_settings = json_encode($seSetting);
            $model->save();
            //
            $this->jsonResponse(200, array(
                'message' => Yii::t('common', 'updatesuccess'),
            ));
        }
    }

    public function actionSetdayoff() {
        if (Yii::app()->request->isAjaxRequest) {
            $workoff = Yii::app()->request->getParam('workoff', 0);
            $id = Yii::app()->request->getParam('id', 0);
            if ($workoff || $id) {
                $day = Yii::app()->request->getParam('day', 0);
                $month = Yii::app()->request->getParam('month', 0);
                $year = Yii::app()->request->getParam('year', date('Y'));
                $repeat = Yii::app()->request->getParam('repeat', 0);
                if ($repeat) {
                    $repeat = ActiveRecord::STATUS_ACTIVED;
                }
                if (!$day || !$month || $day < 1 || $month < 1) {
                    $this->jsonResponse(400, array(
                        'message' => Yii::t('errors', 'content_invalid'),
                    ));
                }
                //
                $daysInMonth = ClaDateTime::get_days_in_month($month, $year);
                if ($day > $daysInMonth) {
                    $this->jsonResponse(400, array(
                        'message' => Yii::t('errors', 'content_invalid'),
                    ));
                }
                //
                if ($id) {
                    $seDayOff = SeDaysoff::model()->findByPk($id);
                    if (!$seDayOff || $seDayOff->site_id!=$this->site_id) {
                        $this->jsonResponse(400, array(
                            'message' => Yii::t('errors', 'content_invalid'),
                        ));
                    }
                    if (!$workoff) {
                        $seDayOff->delete();
                        $this->jsonResponse(200, array(
                            'status' => 'deleted',
                            'id' => $id,
                        ));
                    }
                    if ($seDayOff->repeat != $repeat) {
                        $seDayOff->repeat = $repeat;
                        if ($repeat) {
                            $seDayOff->year = SeDaysoff::year_null;
                        } else {
                            $seDayOff->year = $year;
                        }
                        $seDayOff->save();
                        $this->jsonResponse(200, array(
                            'status' => 'updated',
                            'id' => $id,
                            'repeat' => $repeat,
                            'year' => $year,
                        ));
                    }
                    //
                    $this->jsonResponse(200, array(
                        'message' => Yii::t('common', 'updatesuccess'),
                    ));
                } else {
                    $parent_id = SeDaysoff::parent_id_null;
                    $provider_id = Yii::app()->request->getParam('provider_id', SeDaysoff::provide_id_null);
                    //
                    $seDayOff = new SeDaysoff();
                    $seDayOff->site_id = $this->site_id;
                    $seDayOff->day = $day;
                    $seDayOff->month = $month;
                    $seDayOff->year = ($repeat) ? 0 : $year;
                    $seDayOff->repeat = $repeat;
                    if ($seDayOff->save()) {
                        //
                        $this->jsonResponse(200, array(
                            'message' => Yii::t('common', 'updatesuccess'),
                            'status' => 'created',
                            'id' => $seDayOff->id,
                            'repeat' => $repeat,
                        ));
                    }
                }
            }
        }
    }

    function actionGetcalendar() {
        if (Yii::app()->request->isAjaxRequest) {
            $type = Yii::app()->request->getParam('type', 'next');
            $year = Yii::app()->request->getParam('year', (int) date('Y'));
            if ($type == 'prev') {
                $year = $year - 1;
            } else {
                $year = $year + 1;
            }
            $this->jsonResponse(200, array(
                'html' => $this->renderPartial('partial/holidays', array('year' => $year), true),
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteSettings the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $SiteSettings = new SiteSettings();
        $SiteSettings->setTranslate(false);
        //
        $OldModel = $SiteSettings->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $SiteSettings->setTranslate(true);
            $model = $SiteSettings->findByPk($id);
            if (!$model) {
                $model = new SiteSettings();
                $model->attributes = $OldModel->attributes;
                $model->meta_keywords = '';
                $model->meta_description = '';
                $model->meta_title = '';
                $model->site_logo = '';
                $model->site_title = '';
                $model->contact = '';
                $model->footercontent = '';
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeSettings $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'se-settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
