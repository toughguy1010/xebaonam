<?php

class TransportMethodController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('transportmethod', 'transportmethod_manager') => Yii::app()->createUrl('/economy/course'),
            Yii::t('transportmethod', 'transportmethod_create') => Yii::app()->createUrl('/economy/course/create'),
        );
        $model = new OrderTransport();
        $model->unsetAttributes();
        if (isset($_POST['OrderTransport'])) {
            $model->attributes = $_POST['OrderTransport'];
            $model->processPrice();
            $model->created_time = time();
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(array('index'));
            }
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

        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('transportmethod', Yii::t('transportmethod', 'transport_manager')) => Yii::app()->createUrl('/economy/transportmethod'),
            Yii::t('transportmethod', Yii::t('transportmethod', 'transport_update')) => Yii::app()->createUrl('/economy/transportmethod/update', array('id' => $id)),
        );
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if (isset($_POST['OrderTransport'])) {
            $model->attributes = $_POST['OrderTransport'];
            $model->processPrice();
            $model->modified_time = time();
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(array('index'));
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
        if ($model->site_id != $this->site_id)
            $model->jsonResponse(400);
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa các sản phẩm được chọn
     */
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
//        breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('transportmethod', 'transportmethod_manager')) => Yii::app()->createUrl('/economy/transport'),
        );
//        //
        $model = new OrderTransport('search');
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Orders the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = OrderTransport::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
