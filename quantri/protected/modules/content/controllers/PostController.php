<?php

class PostController extends BackController {

    public $category = null;
    public $category_id = null;
    public $categoryModel = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            $this->categoryModel->cat_name => Yii::app()->createUrl('content/post/index', array('cid' => $this->category_id)),
            Yii::t('post', 'post_create') => Yii::app()->createUrl('/content/post/create', array('cid' => $this->category_id)),
        );
        //
        $model = new Posts;
        //
        $post_category_id = Yii::app()->request->getParam('cat');
        if ($post_category_id)
            $model->category_id = $post_category_id;
        //
        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                $model->publicdate = (int) strtotime($model->publicdate);
            else
                $model->publicdate = time();
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
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                //$this->redirect(Yii::app()->createUrl('content/post/index', array('cid' => $this->category_id)));
                $this->redirect($this->createUrl('/content/post/update', array('cid' => $this->category_id,'id' => $model->id)));
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
        //breadcrumb
        $this->breadcrumbs = array(
            $this->categoryModel->cat_name => Yii::app()->createUrl('content/post/index', array('cid' => $this->category_id)),
            Yii::t('post', 'post_edit') => Yii::app()->createUrl('/content/post/update', array('id' => $id, 'cid' => $this->category_id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Posts'])) {
            $model->attributes = $_POST['Posts'];
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate) > 0)
                $model->publicdate = (int) strtotime($model->publicdate);
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                if ($model->avatar){
                    unset(Yii::app()->session[$model->avatar]);
                }
                //$this->redirect(Yii::app()->createUrl('content/post/index', array('cid' => $this->category_id)));
                $this->redirect($this->createUrl('/content/post/update', array('cid' => $this->category_id,'id' => $model->id)));
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
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

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
        //
        $this->breadcrumbs = array(
            $this->categoryModel->cat_name => Yii::app()->createUrl('content/post/index', array('cid' => $this->category_id)),
        );
        $model = new Posts('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $model->searchAdvance = true;
        $model->category_id = $this->category_id;
        if (isset($_GET['Posts']))
            $model->attributes = $_GET['Posts'];
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Posts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $post = new Posts();
        if (!$noTranslate) {
            $post->setTranslate(false);
        }
        //
        $OldModel = $post->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $post->setTranslate(true);
            $model = $post->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new Posts();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Posts $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'post', 'ava'));
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

    public function allowedActions() {
        return 'uploadfile';
    }

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category_id = Yii::app()->request->getParam('cid');
            if(!$category_id){
                $category_id = Yii::app()->request->getParam('cat');
            }
            $this->categoryModel = PostCategories::model()->findByPk($category_id);
            if (!$this->categoryModel)
                $this->sendResponse(404);
            $this->category_id = $category_id;
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_POST;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

}
