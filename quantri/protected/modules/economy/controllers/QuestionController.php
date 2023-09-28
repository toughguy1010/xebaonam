<?php

class QuestionController extends BackController
{

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('question', 'question_manager') => Yii::app()->createUrl('/economy/question'),
            Yii::t('question', 'question_create') => Yii::app()->createUrl('/economy/question/create'),
        );
        //
        $model = new QuestionAnswer;

        if (isset($_POST['QuestionAnswer'])) {

            $model->attributes = $_POST['QuestionAnswer'];
            $model->site_id = $this->site_id;
            $model->user_id = 0;
            $model->created_time = time();
            if ($model->alias == '') {
                if ($model->question_title != '') {
                    $model->alias = HtmlFormat::parseToAlias($model->question_title);
                } else {
                    $model->alias = HtmlFormat::parseToAlias(HtmlFormat::subCharacter($model->question_content, ' ', 20, 0, ''));
                }
            }
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
                $this->redirect(Yii::app()->createUrl('/economy/question'));
            }
        }
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;

        $this->render('create', array(
            'model' => $model,
            'option_product' => $option_product,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('question', 'question_manager') => Yii::app()->createUrl('/economy/question'),
            Yii::t('question', 'question_update') => Yii::app()->createUrl('question'),
        );
        //
        $model = $this->loadModel($id);
//        $model->setTranslate(false);
        //
        if (isset($_POST['QuestionAnswer'])) {
            $model->attributes = $_POST['QuestionAnswer'];
            if ($model->alias == '') {
                if ($model->question_title != '') {
                    $model->alias = HtmlFormat::parseToAlias($model->question_title);
                } else {
                    $model->alias = HtmlFormat::parseToAlias(HtmlFormat::subCharacter($model->question_content, ' ', 20, 0, ''));
                }
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';
            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/economy/question'));
            }
        }
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;

        $this->render('update', array(
            'model' => $model,
            'option_product' => $option_product,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
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
        $this->breadcrumbs = array(
            Yii::t('question', 'question_manager') => Yii::app()->createUrl('question'),
        );
        $model = new QuestionAnswer('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;

        if (isset($_GET['QuestionAnswer']))
            $model->attributes = $_GET['QuestionAnswer'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $question = new QuestionAnswer();
        $question->setTranslate(false);
//        $news->setTranslate(false);
        //
        $OldModel = $question->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $question->setTranslate(false);
            $model = $question->findByPk($id);
            if (!$model) {
                $model = new QuestionAnswer();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'question-form') {
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
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'question', 'ava'));
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

    public function allowedActions()
    {
        return 'uploadfile';
    }

    function beforeAction($action)
    {
        //
        //
        return parent::beforeAction($action);
    }

}
