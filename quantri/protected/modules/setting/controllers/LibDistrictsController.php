<?php

class LibDistrictsController extends BackController {

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
            Yii::t('common', 'manager_district') => Yii::app()->createUrl('/setting/libDistricts'),
            Yii::t('common', 'create') => Yii::app()->createUrl('/setting/libDistricts/create'),
        );
        $model = new LibDistricts;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibDistricts'])) {
            $model->attributes = $_POST['LibDistricts'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $listprovince = LibProvinces::getListProvinceArr();

        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince
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
            Yii::t('common', 'manager_district') => Yii::app()->createUrl('/setting/libDistricts'),
            Yii::t('common', 'create') => Yii::app()->createUrl('/setting/libDistricts/create'),
        );
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibDistricts'])) {
            $model->attributes = $_POST['LibDistricts'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $listprovince = LibProvinces::getListProvinceArr();

        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'manager_district') => Yii::app()->createUrl('/setting/libDistricts'),
        );
        
        $model = new LibDistricts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LibDistricts'])) {
            $model->attributes = $_GET['LibDistricts'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LibDistricts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LibDistricts::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LibDistricts $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lib-districts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
