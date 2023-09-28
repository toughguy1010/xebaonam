<?php

class CustomerReviewsController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('reviews', 'reviews_manager') => Yii::app()->createUrl('/interface/customerReviews'),
        );
        //
        $model = new CustomerReviews('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['CustomerReviews'])) {
            $model->attributes = $_GET['CustomerReviews'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('reviews', 'reviews_manager') => Yii::app()->createUrl('/interface/customerReviews'),
            Yii::t('reviews', 'reviews_create') => Yii::app()->createUrl('/interface/customerReviews/create'),
        );
        $model = new CustomerReviews();
        $model->actived = ActiveRecord::STATUS_ACTIVED;
        $post = Yii::app()->request->getPost('CustomerReviews');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }
        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('reviews', 'reviews_manager') => Yii::app()->createUrl('/interface/customerReviews'),
            Yii::t('reviews', 'reviews_update') => Yii::app()->createUrl('/interface/customerReviews/update'),
        );
        $model = $this->loadModel($id);
        
        $post = Yii::app()->request->getPost('CustomerReviews');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Course the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = new CustomerReviews();

        $model->setTranslate(false);
        //
        $OldModel = $model->findByPk($id);

        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $model->setTranslate(true);
            $model = $model->findByPk($id);
            if (!$model) {

                $model = new CustomerReviews();
                $model->attributes = $OldModel->attributes;
                $model->alias =  '';
            }
        } else
            $model = $OldModel;
        //
        return $model;

    }

    public function actionDelete($id) {
        $broker = $this->loadModel($id);
        $broker->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'customer_reviews', 'ava'));
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

}
