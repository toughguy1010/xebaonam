<?php

class RmaController extends BackController
{

    /**
     * Updates a rma model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        /*Init*/
        $this->breadcrumbs = array(
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'rma_manager')) => Yii::app()->createUrl('/economy/rma'),
            Yii::t('shoppingcart', Yii::t('shoppingcart', 'rma_update')) => Yii::app()->createUrl('/economy/rma/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        //
        if (isset($_POST['RmaCompanyInfomation'])) {
            $model->status = $_POST['RmaCompanyInfomation']['status'];
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('economy/rma'));
            }
        }
        //
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $rma = $this->loadModel($id);
        if ($rma->site_id != $this->site_id)
            $this->jsonResponse(400);
        $rma->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa các sản phẩm được chọn
     */
    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
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
    public function actionIndex()
    {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'rma_manager')) => Yii::app()->createUrl('/economy/rma')
        );
        $model = new RmaCompanyInfomation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RmaCompanyInfomation'])) {
            $model->attributes = $_GET['RmaCompanyInfomation'];
            $model->from_date = $_GET['RmaCompanyInfomation']['from_date'];
            $model->to_date = $_GET['RmaCompanyInfomation']['to_date'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RmaCompanyInfomation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = RmaCompanyInfomation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RmaCompanyInfomation $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rmas-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
