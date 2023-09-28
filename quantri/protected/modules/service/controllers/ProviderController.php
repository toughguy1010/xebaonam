<?php

class ProviderController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'provider_manager') => Yii::app()->createUrl('service/provider'),
            Yii::t('service', 'provider_create') => Yii::app()->createUrl('/service/provider/create'),
        );
        //
        $model = new SeProviders;
        $model->scenario = 'create';
        $model->site_id = $this->site_id;
        $providerInfo = new SeProvidersInfo;
        $providerInfo->site_id = $this->site_id;
        if (isset($_POST['SeProviders'])) {
            $model->attributes = $_POST['SeProviders'];
            if (isset($_POST['SeProvidersInfo'])) {
                $providerInfo->attributes = $_POST['SeProvidersInfo'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if($model->language) {
                $model->language = implode(' ', $model->language);
            }
            if ($model->save()) {
                $providerInfo->provider_id = $model->id;
                $providerInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/service/provider/update', array('id' => $model->id)));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'providerInfo' => $providerInfo,
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
            Yii::t('service', 'provider_manager') => Yii::app()->createUrl('service/provider'),
            Yii::t('service', 'provider_edit') => Yii::app()->createUrl('/service/provider/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $providerInfo = $this->loadModelProviderInfo($id);
        if (isset($_POST['SeProviders'])) {
            $model->attributes = $_POST['SeProviders'];
            if (isset($_POST['SeProvidersInfo'])) {
                $providerInfo->attributes = $_POST['SeProvidersInfo'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if($model->language) {
                $model->language = implode(' ', $model->language);
            }
            if ($model->save()) {
                $providerInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('service/provider'));
            }
        }

        $businessHours = SeProviderSchedules::getProviderSchedules(array(
                    'provider_id' => $id,
        ));

        $this->render('update', array(
            'model' => $model,
            'businessHours' => $businessHours,
            'providerInfo' => $providerInfo,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
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
                    if ($model->site_id == $this->site_id) {
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
            Yii::t('service', 'provider') => Yii::app()->createUrl('service/provider'),
        );
        //
        $model = new SeProviders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SeProviders'])) {
            $model->attributes = $_GET['SeProviders'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
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
        $provider = new SeProviders();
        if (!$noTranslate) {
            $provider->setTranslate(false);
        }
        //
        $OldModel = $provider->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $provider->setTranslate(true);
            $model = $provider->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new SeProviders();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        return $model;
    }

    public function loadModelProviderInfo($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $providerInfo = new SeProvidersInfo();
        if (!$noTranslate) {
            $providerInfo->setTranslate(false);
        }
        //
        $OldModel = $providerInfo->findByPk($id);
        //
        if (!$noTranslate && $language) {
            $providerInfo->setTranslate(true);
            $model = $providerInfo->findByPk($id);
            if (!$model) {
                $model = new SeProvidersInfo();
                $model->provider_id = $id;
                $model->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $model = $OldModel;
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SeProviders $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'se-providers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'providers', 'ava'));
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

    //
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionaddService() {
        if (Yii::app()->request->isAjaxRequest) {
            $provider_id = Yii::app()->request->getParam('provider_id', 0);
            $model = $this->loadModel($provider_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $allServices = SeServices::getServices();
            $postServices = $_POST['Service'];
            //
            foreach ($allServices as $service) {
                $seProviderService = SeProviderServices::model()->findByAttributes(array(
                    'site_id' => $this->site_id,
                    'provider_id' => $provider_id,
                    'service_id' => $service['id'],
                ));
                $select = isset($postServices[$service['id']]) ? (int) $postServices[$service['id']] : 0;
                if (!$select && $seProviderService) {
                    $seProviderService->delete();
                } else if ($select) {
                    if (!$seProviderService) {
                        $seProviderService = new SeProviderServices();
                    }
                    $seProviderService->provider_id = $provider_id;
                    $seProviderService->service_id = $service['id'];
                    $seProviderService->price = floatval($postServices[$service['id']]['price']);
                    $seProviderService->duration = (int) $postServices[$service['id']]['duration'];
                    $seProviderService->capacity = (int) $postServices[$service['id']]['capacity'];
                    $seProviderService->save();
                }
                //
            }
            $this->jsonResponse(200, array(
                'message' => Yii::t('common', 'updatesuccess'),
            ));
        }
    }

    public function actionSetdayoff() {
        if (Yii::app()->request->isAjaxRequest) {
            $provider_id = Yii::app()->request->getParam('provider_id', 0);
            $workoff = Yii::app()->request->getParam('workoff', 0);
            $id = Yii::app()->request->getParam('id', 0);
            if ($provider_id && ($workoff || $id)) {
                $provider = $this->loadModel($provider_id);
                if ($provider->site_id != $this->site_id) {
                    $this->jsonResponse(400, array(
                        'message' => Yii::t('errors', 'content_invalid'),
                    ));
                }
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
                    if (!$seDayOff || $seDayOff->site_id != $this->site_id || $seDayOff->provider_id != $provider_id) {
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
                    //
                    $seDayOff = new SeDaysoff();
                    $seDayOff->site_id = $this->site_id;
                    $seDayOff->day = $day;
                    $seDayOff->month = $month;
                    $seDayOff->year = ($repeat) ? 0 : $year;
                    $seDayOff->repeat = $repeat;
                    $seDayOff->provider_id = $provider_id;
                    $seDayOff->parent_id = $parent_id;
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
            $provider_id = Yii::app()->request->getParam('provider_id', 0);
            $model = $this->loadModel($provider_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $type = Yii::app()->request->getParam('type', 'next');
            $year = Yii::app()->request->getParam('year', (int) date('Y'));
            if ($type == 'prev') {
                $year = $year - 1;
            } else {
                $year = $year + 1;
            }
            $this->jsonResponse(200, array(
                'html' => $this->renderPartial('partial/_holidays', array('year' => $year, 'model' => $model), true),
            ));
        }
    }

    /*
     * save bussiness hours
     */

    public function actionBusinesshours() {
        if (Yii::app()->request->isAjaxRequest) {
            $provider_id = Yii::app()->request->getParam('provider_id', 0);
            $model = $this->loadModel($provider_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
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
            foreach ($businessHours as $dayindex => $hour) {
                $error = false;
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
                $provider_schedule_id = (int) $hour['id'];
                if (!$provider_schedule_id) {
                    $error = true;
                    break;
                }
                $providerSchedule = SeProviderSchedules::model()->findByPk($provider_schedule_id);
                if (!$providerSchedule || $providerSchedule->site_id != $this->site_id) {
                    $error = true;
                    break;
                }
                if ($error) {
                    $this->jsonResponse(400, array(
                        'message' => Yii::t('errors', 'content_invalid'),
                    ));
                    break;
                }
                $providerSchedule->start_time = $hour['start_time'];
                $providerSchedule->end_time = $hour['end_time'];
                $providerSchedule->save();
            }
            //
            $this->jsonResponse(200, array(
                'message' => Yii::t('common', 'updatesuccess'),
            ));
        }
    }

    function actionAddbreaktime() {
        if (Yii::app()->request->isAjaxRequest) {
            $provider_id = Yii::app()->request->getParam('provider_id', 0);
            $model = $this->loadModel($provider_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $breakTime = $_POST['BreakTime'];
            $error = false;
            if (!isset($breakTime['start_time']) || !isset($breakTime['end_time'])) {
                $error = true;
            } else if ((int) $breakTime['start_time'] > $breakTime['end_time']) {
                $error = true;
            } else if ((int) $breakTime['start_time'] > ClaService::max_time_length || (int) $breakTime['end_time'] > ClaService::max_time_length) {
                $error = true;
            }
            if ($error) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $schedule_id = isset($breakTime['schedule_id']) ? (int) $breakTime['schedule_id'] : 0;
            if (!$schedule_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $schedule = SeProviderSchedules::model()->findByPk($schedule_id);
            if (!$schedule || $schedule->site_id != $this->site_id) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }

            $listBreakTimes = SeProviderScheduleBreaks::getProviderScheduleBreaks(array(
                        'provider_schedule_id' => $schedule_id,
            ));
            if (ClaDateTime::checkIntersectTime($breakTime['start_time'], $breakTime['end_time'], $listBreakTimes)) {
                $this->jsonResponse(400, array(
                    'message' => Yii::t('errors', 'content_invalid'),
                ));
            }
            $providerBreak = new SeProviderScheduleBreaks();
            $providerBreak->provider_schedule_id = $schedule_id;
            $providerBreak->start_time = (int) $breakTime['start_time'];
            $providerBreak->end_time = (int) $breakTime['end_time'];
            if ($providerBreak->save()) {
                $this->jsonResponse(200, array(
                    'message' => Yii::t('common', 'updatesuccess'),
                    'breakTimeBox' => $this->renderPartial('partial/_breakTimeBox', array('model' => $providerBreak), true),
                ));
            }
            //
        }
    }

    function actionDeletebreaktime($id) {
        $providerBreak = SeProviderScheduleBreaks::model()->findByPk($id);
        if (!$providerBreak || $providerBreak->site_id != $this->site_id) {
            $this->jsonResponse(400, array(
                'message' => Yii::t('errors', 'content_invalid'),
            ));
        }
        if ($providerBreak->delete()) {
            $this->jsonResponse(200);
        }
    }
    
    public function actionDeleteAvatar() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $provider = $this->loadModel($id);
                if ($provider) {
                    $provider->avatar_path = '';
                    $provider->avatar_name = '';
                    $provider->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

}
