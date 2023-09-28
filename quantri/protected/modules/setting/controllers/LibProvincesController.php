<?php

class LibProvincesController extends BackController {

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
        $model = new LibProvinces;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibProvinces'])) {
            $model->attributes = $_POST['LibProvinces'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->province_id));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['LibProvinces'])) {
            $model->attributes = $_POST['LibProvinces'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->province_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'manager_province') => Yii::app()->createUrl('/setting/libProvinces'),
        );

        $model = new LibProvinces('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['LibProvinces'])) {
            $model->attributes = $_GET['LibProvinces'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return LibProvinces the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = LibProvinces::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param LibProvinces $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lib-provinces-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
