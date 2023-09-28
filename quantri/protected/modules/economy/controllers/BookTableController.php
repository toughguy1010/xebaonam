<?php

class BookTableController extends BackController {

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = BookTable::model()->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX comment (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('book_table', 'list_book_table') => Yii::app()->createUrl('economy/bookTable'),
        );
        //
        $model = new BookTable('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['BookTable'])) {
            $model->attributes = $_GET['BookTable'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionSetCampaign() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('book_table', 'set_campaign') => Yii::app()->createUrl('economy/bookTable/setCampaign'),
        );

        $site_id = Yii::app()->controller->site_id;
        $model = BookTableCampaign::model()->findByPk($site_id);
        if ($model === NULL) {
            $model = new BookTableCampaign();
        }

        if (isset($_POST['BookTableCampaign']) && $_POST['BookTableCampaign']) {
            $model->attributes = $_POST['BookTableCampaign'];
            if ($model->type == BookTableCampaign::TYPE_PERCENT) {
                $model->price = 0;
            } else if($model->type == BookTableCampaign::TYPE_PRICE) {
                $model->percent = 0;
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Lưu thành công');
                $this->redirect(array('setCampaign'));
            }
        }

        $this->render('set_campaign', array(
            'model' => $model
        ));
    }

    /**
     * Xóa các coment được chọn
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Requests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = BookTable::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The commentratinged page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'book-table-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        return parent::beforeAction($action);
    }

}
