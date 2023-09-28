<?php

class SiteUsersController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('/economy/siteUsers/index'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/siteUsers/create'),
        );

        $model = new SiteUsers();
        $model->unsetAttributes();

        if (isset($_POST['SiteUsers'])) {
            $model->attributes = $_POST['SiteUsers'];
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            //
            //
            if ($model->save()) {

                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }

        $this->render('adduser', array(
            'model' => $model,
//            'courseInfo' => $courseInfo,
//            'category' => $category,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('/economy/siteUsers/index'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/siteUsers/update'),
        );

        $model = $this->loadModel($id);

        if (isset($_POST['SiteUsers'])) {
            $model->attributes = $_POST['SiteUsers'];
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            //
            //
            if ($model->save()) {

                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }

        $this->render('adduser', array(
            'model' => $model,
//            'courseInfo' => $courseInfo,
//            'category' => $category,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('/economy/siteUsers/index'),
        );
        $model = new SiteUsers('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Course'])) {
            $model->attributes = $_GET['Course'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Course('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Course']))
            $model->attributes = $_GET['Course'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        //
        $SiteUsers = new SiteUsers();
        $SiteUsers->setTranslate(false);
        //
        $OldModel = $SiteUsers->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested 2 page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $SiteUsers->setTranslate(true);
            $model = $SiteUsers->findByPk($id);
            if (!$model) {
                $model = new SiteUsers();
                $model->id = $id;
                $model->name = $OldModel->name;
                $model->job_title = $OldModel->job_title;
                $model->phone = $OldModel->phone;
                $model->email = $OldModel->email;
                $model->skype = $OldModel->skype;
                $model->yahoo = $OldModel->yahoo;
                $model->avatar_path = $OldModel->avatar_path;
                $model->avatar_name = $OldModel->avatar_name;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }
    
    /**
     * Performs the AJAX validation.
     * @param Course $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'course-form') {
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
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'siteusers', 'ava'));
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

}
