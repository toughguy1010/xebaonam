<?php

class CarAttributeGroupController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_attribute_group') => Yii::app()->createUrl('/car/carAttributeGroup/'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carAttributeGroup/create', array('id' => $id)),
        );
        
        $model = new CarAttributeGroup();

        $post = Yii::app()->request->getPost('CarAttributeGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carAttributeGroup"));
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
            Yii::t('car', 'manager_attribute_group') => Yii::app()->createUrl('/car/carAttributeGroup/'),
            Yii::t('car', 'update') => Yii::app()->createUrl('/car/carAttributeGroup/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('CarAttributeGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            //
            $model->attributes = $post;
            //
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("car/carAttributeGroup"));
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

        $model = CarAttributeGroup::model()->findByPk($id);
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
            Yii::t('car', 'manager_attribute_group') => Yii::app()->createUrl('/car/carAttributeGroup'),
        );

        $model = new CarAttributeGroup();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CarAttributeGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CarAttributeGroup'])) {
            $model->attributes = $_GET['CarAttributeGroup'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CarAttributeGroup the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = CarAttributeGroup::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CarAttributeGroup $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
