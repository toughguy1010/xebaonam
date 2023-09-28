<?php

class CarAttributeCategoryController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_attribute_category') => Yii::app()->createUrl('/car/carAttributeCategory/'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carAttributeCategory/create', array('id' => $id)),
        );
        
        $model = new CarAttributeCategory();

        $post = Yii::app()->request->getPost('CarAttributeCategory');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carAttributeCategory"));
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
            Yii::t('car', 'manager_attribute_category') => Yii::app()->createUrl('/car/carAttributeCategory/'),
            Yii::t('car', 'update') => Yii::app()->createUrl('/car/carAttributeCategory/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('CarAttributeCategory');

        if (Yii::app()->request->isPostRequest && $post) {
            //
            $model->attributes = $post;
            //
            if ($model->save()) {
                //
                // SAVE OPTION 
                if (isset($_POST['CarAttributeOption'])) {
                    $values = $_POST['CarAttributeOption'];
                    if (count($values)) {
                        foreach ($values as $value) {
                            $optionValue = new CarAttributeOption();
                            $optionValue->category_id = $model->id;
                            $optionValue->name = $value['name'];
                            $optionValue->order = $value['order'];
                            $optionValue->save();
                        }
                    }
                }
                if (isset($_POST['CarAttributeOptionExist'])) {
                    $valuesExist = $_POST['CarAttributeOptionExist'];
                    if (count($valuesExist)) {
                        foreach ($valuesExist as $vid => $value) {
                            $optionValue = CarAttributeOption::model()->findByPk($vid);
                            $optionValue->category_id = $model->id;
                            $optionValue->name = $value['name'];
                            $optionValue->order = $value['order'];
                            $optionValue->save();
                        }
                    }
                }
                //
                $this->redirect(Yii::app()->createUrl("car/carAttributeCategory"));
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

        $model = CarAttributeCategory::model()->findByPk($id);
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
            Yii::t('car', 'manager_attribute_category') => Yii::app()->createUrl('/car/carAttributeCategory'),
        );

        $model = new CarAttributeCategory();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CarAttributeCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CarAttributeCategory'])) {
            $model->attributes = $_GET['CarAttributeCategory'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CarAttributeCategory the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = CarAttributeCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CarAttributeCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
