<?php

class SmsCustomerGroupController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('sms', 'customer_group') => Yii::app()->createUrl('/sms/smsCustomerGroup/'),
            Yii::t('sms', 'customer_group_create') => Yii::app()->createUrl('/sms/smsCustomerGroup/create'),
        );
        $model = new SmsCustomerGroup();

        $post = Yii::app()->request->getPost('SmsCustomerGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/sms/smsCustomerGroup"));
            }
        }

        $this->render('addgroup', array(
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
            Yii::t('sms', 'customer_group') => Yii::app()->createUrl('/sms/smsCustomerGroup/'),
            Yii::t('sms', 'customer_group_update') => Yii::app()->createUrl('/sms/smsCustomerGroup/update'),
        );
        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('SmsCustomerGroup');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/sms/smsCustomerGroup"));
            }
        }

        $this->render('addgroup', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $model = SmsCustomerGroup::model()->findByPk($id);
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
            Yii::t('sms', 'customer_group') => Yii::app()->createUrl('/sms/smsCustomerGroup'),
        );

        $model = new SmsCustomerGroup();
        $model->site_id = $this->site_id;
        $this->render('listgroup', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        $model = SmsCustomerGroup::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('sms', 'customer_group') => Yii::app()->createUrl('/sms/smsCustomerGroup'),
            $model->name => '',
        );
        $model_customer = new SmsCustomer();
        $model_customer->unsetAttributes();  // clear any default values
        if (isset($_GET['SmsCustomer'])) {
            $model_customer->attributes = $_GET['SmsCustomer'];
        }
        $model_customer->group_id = $id;
        $this->render('view', array(
            'model' => $model,
            'model_customer' => $model_customer,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CourseCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SmsCustomerGroup::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CourseCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sms-customer-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id) {
                Yii::app()->end();
            }
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    $model->delete();
                }
            }
        }
    }

}
