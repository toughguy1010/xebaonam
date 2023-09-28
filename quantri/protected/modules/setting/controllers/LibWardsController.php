<?php

class LibWardsController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'manager_ward') => Yii::app()->createUrl('/setting/libWards'),
            Yii::t('common', 'create') => Yii::app()->createUrl('/setting/libWards/create'),
        );
        $model = new LibWards;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibWards'])) {
            $model->attributes = $_POST['LibWards'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        
        // get address options
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict
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
            Yii::t('common', 'manager_ward') => Yii::app()->createUrl('/setting/libWards'),
            Yii::t('common', 'update') => Yii::app()->createUrl('/setting/libWards/update'),
        );
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibWards'])) {
            $model->attributes = $_POST['LibWards'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        
        // get address options
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $this->render('update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'manager_ward') => Yii::app()->createUrl('/setting/libWards'),
        );
        
        $model = new LibWards('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LibWards'])) {
            $model->attributes = $_GET['LibWards'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LibWards the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LibWards::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LibWards $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lib-wards-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
