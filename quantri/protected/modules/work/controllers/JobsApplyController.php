<?php

class JobsApplyController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('work', 'work') => Yii::app()->createUrl('/work/jobs'),
            Yii::t('work', 'job_create') => Yii::app()->createUrl('/work/jobs/create'),
        );
        $model = new Jobs;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['Jobs'])) {
            $model->attributes = $_POST['Jobs'];
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                $model->publicdate = (int) strtotime($model->publicdate);
            else
                $model->publicdate = time();
            //
            if ($model->expirydate && $model->expirydate != '' && (int) strtotime($model->expirydate))
                $model->expirydate = (int) strtotime($model->expirydate);
            else
                $model->expirydate = 0;
            //
            $model->user_id = Yii::app()->user->id;
            //
            // validate location
            $_locations = $model->location;
            $locations = array();
            if ($_locations) {
                $provinces = LibProvinces::getListProvinceArr();
                foreach ($_locations as $location) {
                    if (isset($provinces[$location]))
                        $locations[$location] = $location;
                }
            }
            if (count($locations))
                $model->location = implode(',', $locations);
            else
                $model->location = '';
            //validate salary range
            $salaryrange = Jobs::getSalaryRangeTypes();
            if (!isset($salaryrange[$model->salaryrange]))
                $this->sendResponse(400);
            if ($model->salaryrange == Jobs::SALARYRANGE_DETAIL) {
                $model->salary_min = doubleval($model->salary_min);
                $model->salary_max = doubleval($model->salary_max);
                if ($model->salary_min == 0 || $model->salary_max == 0 || $model->salary_min > $model->salary_max)
                    $model->addError('salaryrange', Yii::t('errors', 'salaryrange_invalid'));
            }
            //
            if ($model->validate(null, false)) {
                //validate degree
                $degree = Jobs::getDegree();
                if (!isset($degree[$model->degree]))
                    $this->sendResponse(400);
                //validate trade
                $trades = Trades::getTradeArr();
                if (!isset($trades[$model->trade_id]))
                    $this->sendResponse(400);
                //validate type of work
                $typeofwork = Jobs::getTypeOfJob();
                if (!isset($typeofwork[$model->typeofwork]))
                    $this->sendResponse(400);
                // validate level
                $levels = Jobs::getLevelTypes();
                if (!isset($levels[$model->level]))
                    $this->sendResponse(400);
                //
                // validate experience
                $experiences = Jobs::getExperienceTypes();
                if (!isset($experiences[$model->experience]))
                    $this->sendResponse(400);
                //
                if ($model->avatar) {
                    $avatar = Yii::app()->session[$model->avatar];
                    if (!$avatar) {
                        $model->avatar = '';
                    } else {
                        $model->image_path = $avatar['baseUrl'];
                        $model->image_name = $avatar['name'];
                    }
                }
                if ($model->save(false))
                    $this->redirect(Yii::app()->createUrl('/work/jobs'));
            }
            //
//            if ($model->save())
//                $this->redirect(array('view', 'id' => $model->id));
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
        $this->breadcrumbs = array(
            Yii::t('work', 'work') => Yii::app()->createUrl('/work/jobs'),
            Yii::t('work', 'job_update') => Yii::app()->createUrl('/work/jobs/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Jobs'])) {
            $model->attributes = $_POST['Jobs'];
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                $model->publicdate = (int) strtotime($model->publicdate);
            else
                $model->publicdate = time();
            //
            if ($model->expirydate && $model->expirydate != '' && (int) strtotime($model->expirydate))
                $model->expirydate = (int) strtotime($model->expirydate);
            else
                $model->expirydate = 0;
            //
            $model->site_id = $this->site_id;
            //
            // validate location
            $_locations = $model->location;
            $locations = array();
            if ($_locations) {
                $provinces = LibProvinces::getListProvinceArr();
                foreach ($_locations as $location) {
                    if (isset($provinces[$location]))
                        $locations[$location] = $location;
                }
            }
            if (count($locations))
                $model->location = implode(',', $locations);
            else
                $model->location = '';
            //validate salary range
            $salaryrange = Jobs::getSalaryRangeTypes();
            if (!isset($salaryrange[$model->salaryrange]))
                $this->sendResponse(400);
            if ($model->salaryrange == Jobs::SALARYRANGE_DETAIL) {
                $model->salary_min = doubleval($model->salary_min);
                $model->salary_max = doubleval($model->salary_max);
                if ($model->salary_min == 0 || $model->salary_max == 0 || $model->salary_min > $model->salary_max)
                    $model->addError('salaryrange', Yii::t('errors', 'salaryrange_invalid'));
            }
            //
            if ($model->validate(null, false)) {
                //validate degree
                $degree = Jobs::getDegree();
                if (!isset($degree[$model->degree]))
                    $this->sendResponse(400);
                //validate trade
                $trades = Trades::getTradeArr();
                if (!isset($trades[$model->trade_id]))
                    $this->sendResponse(400);
                //validate type of work
                $typeofwork = Jobs::getTypeOfJob();
                if (!isset($typeofwork[$model->typeofwork]))
                    $this->sendResponse(400);
                // validate level
                $levels = Jobs::getLevelTypes();
                if (!isset($levels[$model->level]))
                    $this->sendResponse(400);
                //
                // validate experience
                $experiences = Jobs::getExperienceTypes();
                if (!isset($experiences[$model->experience]))
                    $this->sendResponse(400);
                //
                if ($model->avatar) {
                    $avatar = Yii::app()->session[$model->avatar];
                    if ($avatar) {
                        $model->image_path = $avatar['baseUrl'];
                        $model->image_name = $avatar['name'];
                    }
                }
                //
                if ($model->save(false))
                    $this->redirect(Yii::app()->createUrl('/work/jobs'));
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

    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('work', 'list_apply') => Yii::app()->createUrl('/work/jobs/listApply'),
        );
        $model = new JobApply();
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Jobs'])) {
            $model->attributes = $_GET['Jobs'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $job = Jobs::model()->findByPk($model->job_id);

        $this->render('view', array(
            'model' => $model,
            'job' => $job
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Jobs the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = JobApply::model()->findByPk($id);
        if ($model === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Jobs $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jobs-form') {
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
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'jobs'));
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

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * hungtm
     * export to csv
     */
    public function actionExportcsv() {
        $arrFields = array(
            'Tên ứng viên',
            'Vị trí ứng tuyển',
            'Ngày sinh',
            'Giới tính',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Ngày ứng tuyển',
            'Học vấn',
            'Chứng chỉ khác',
        );
        $string = implode("\t", $arrFields) . "\n";

        $applys = Yii::app()->db->createCommand()
                ->select('*')
                ->from('job_apply')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('id DESC')
                ->queryAll();

        foreach ($applys as $apply) {
            // giới tính
            $sex = ($apply['sex'] == 1) ? 'Nam' : 'Nữ';
            // học vấn
            $knowledge = JobApply::getKnowledgeHistory($apply['id']);
            $school = '';
            if ($knowledge) {
                foreach ($knowledge as $item) {
                    $arr = array();
                    if ($item['qualification_type']) {
                        $arr[] = 'Hệ: ' . $item['qualification_type'];
                    }
                    if ($item['qualification_type']) {
                        $arr[] = 'Ngành: ' . $item['major'];
                    }
                    if ($item['school']) {
                        $arr[] = 'Trường: ' . $item['school'];
                    }
                    if ($school != '') {
                        $school .= ' / ';
                    }
                    $school .= implode(' - ', $arr);
                }
            }
            //
            $created_time = date('d/m/Y', $apply['created_time']);
            //
            $job = Jobs::model()->findByPk($apply['job_id']);
            //
            $arr = array(
                $apply['name'],
                $job->position,
                $apply['birthday'],
                $sex,
                $apply['email'],
                $apply['hotline'],
                $apply['address'],
                $created_time,
                $school,
                $apply['certificate'],
            );
            $string .= implode("\t", $arr) . "\n";
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");

        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');


        echo $string;
    }

}
