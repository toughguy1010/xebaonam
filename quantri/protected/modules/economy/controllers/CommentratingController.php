<?php

class CommentratingController extends BackController {

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'commentrating_manger') => Yii::app()->createUrl('economy/commentrating'),
            Yii::t('comment', 'commentrating_edit') => Yii::app()->createUrl('economy/commentrating/update', array('id' => $id)),
        );
        //Change viewed
        if( $model->is_view == 0){
            $model->is_view = 1;
            $model->save();
        }
        // Find product name
        $product = Product::model()->findByPk($model->product_id);
        if (isset($_POST['ProductRating'])) {
            $model->status = $_POST['ProductRating']['status'];
            //IF show => add rating
            if ($model->save()){
                if($model->status == 1){
                    $product_info = ProductInfo::model()->findByPk($model->product_id);
                    if($product_info){
                        $average_rating = ProductRating::getRatingPoint($model->product_id);
                        $total_num_rating = ProductRating::countNumRating($model->product_id);
                        $product_info->total_rating = $average_rating;
                        $product_info->total_votes = $total_num_rating;
                        $product_info->save();
                    }
                }
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'product' => $product,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->commentrating->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX commentrating (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'comment_rating_content') => Yii::app()->createUrl('content/commentrating'),
        );
        //
        $model = new ProductRating('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Requests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductRating::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The commentratinged page does not exist.');
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'commentratings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        return parent::beforeAction($action);
    }

}
