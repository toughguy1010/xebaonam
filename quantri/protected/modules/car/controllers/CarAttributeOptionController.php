<?php

class CarAttributeOptionController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_attribute_option') => Yii::app()->createUrl('/car/carAttributeOption/'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carAttributeOption/create', array('id' => $id)),
        );

        $model = new CarAttributeOption();

        $post = Yii::app()->request->getPost('CarAttributeOption');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carAttributeOption"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_attribute_option') => Yii::app()->createUrl('/car/carAttributeOption/'),
            Yii::t('car', 'update') => Yii::app()->createUrl('/car/carAttributeOption/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('CarAttributeOption');

        if (Yii::app()->request->isPostRequest && $post) {
            //
            $model->attributes = $post;
            //
            if ($model->save()) {
                //
                // SAVE OPTION VALUE
                if (isset($_POST['CarAttributeOptionValue'])) {
                    $values = $_POST['CarAttributeOptionValue'];
                    if (count($values)) {
                        foreach ($values as $value) {
                            $optionValue = new CarAttributeOptionValue();
                            $optionValue->option_id = $model->id;
                            $optionValue->name = $value['name'];
                            $optionValue->order = $value['order'];
                            $optionValue->save();
                        }
                    }
                }
                if (isset($_POST['CarAttributeOptionValueExist'])) {
                    $valuesExist = $_POST['CarAttributeOptionValueExist'];
                    if (count($valuesExist)) {
                        foreach ($valuesExist as $vid => $value) {
                            $optionValue = CarAttributeOptionValue::model()->findByPk($vid);
                            $optionValue->option_id = $model->id;
                            $optionValue->name = $value['name'];
                            $optionValue->order = $value['order'];
                            $optionValue->save();
                        }
                    }
                }
                //
                $this->redirect(Yii::app()->createUrl("car/carAttributeOption"));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $model = CarAttributeOption::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_attribute_option') => Yii::app()->createUrl('/car/carAttributeOption'),
        );

        $model = new CarAttributeOption();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CarAttributeOption('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CarAttributeOption'])) {
            $model->attributes = $_GET['CarAttributeOption'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CarAttributeOption the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = CarAttributeOption::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CarAttributeOption $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
