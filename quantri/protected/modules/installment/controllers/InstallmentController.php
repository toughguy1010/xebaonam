<?php

class InstallmentController extends BackController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function actionCreate()
    {

        $this->breadcrumbs = array(
            'Ngân hàng tài chính' => Yii::app()->createUrl('/installment/installment/'),
            Yii::t('common', 'create') => Yii::app()->createUrl('/installment/installment/create', array('id' => $id)),
        );
        $this->setPageTitle('Tạo mới');
        $model = new Installment();
        $post = Yii::app()->request->getPost('Installment');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/installment/installment/"));
            }
        }
        $this->render('addcat', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        $this->breadcrumbs = array(
            'Ngân hàng tài chính' => Yii::app()->createUrl('/installment/installment/'),
            Yii::t('common', 'update') => Yii::app()->createUrl('/installment/installment/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = '';
            $model->image_name = '';
        }
        if ($model->collection_fee)
            $model->collection_fee = HtmlFormat::money_format($model->collection_fee);
        $post = Yii::app()->request->getPost('Installment');
        if (Yii::app()->request->isPostRequest && $post) {

            //
            $model->attributes = $post;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            //
            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("installment/installment"));
            }
        }
        // If not post

        $this->render('addcat', array(
            'model' => $model,
        ));
    }
    public function actionDeleteAvatar()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $installment = $this->loadModel($id);
                if ($installment) {
                    $installment->image_path = '';
                    $installment->image_name = '';
                    $installment->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Ngân hàng tài chính' => Yii::app()->createUrl('/installment/installment'),
        );

        $model = new Installment();
        $model->site_id = $this->site_id;
        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    public function actionOrder()
    {
//breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('shoppingcatr', Yii::t('shoppingcart', 'order_manager')) => Yii::app()->createUrl('/economy/order')
        );
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders'])) {
            $model->attributes = $_GET['Orders'];
            $model->from_date = $_GET['Orders']['from_date'];
            $model->to_date = $_GET['Orders']['to_date'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }
    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new AlbumsCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AlbumsCategories']))
            $model->attributes = $_GET['AlbumsCategories'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AlbumsCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {

        //
        $installment = new Installment();
        $installment->setTranslate(false);
        //
        $OldModel = $installment->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $installment->setTranslate(true);
            $model = $installment->findByPk($id);
            if (!$model) {
                $model = new Installment();
                $model->id = $id;
                $model->image_path = $OldModel->image_path;
                $model->image_name = $OldModel->image_name;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AlbumsCategories $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'albums-categories-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'albums', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function actionUpdateorder($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = AlbumsCategories::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $order = (int)Yii::app()->request->getParam('or');
            //
            if ($order) {
                $model->cat_order = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

}
