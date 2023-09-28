<?php

class TranslateLanguageOptionController extends BackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_option_rel_manager') => Yii::app()->createUrl('/economy/translateLanguageOption'),
            Yii::t('translate', 'translate_option_rel_create') => Yii::app()->createUrl('/economy/translateLanguageOption/create'),
        );

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new TranslateLanguageOptionRel;

        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_option_rel_manager') => Yii::app()->createUrl('/economy/translateLanguageOption'),
            Yii::t('translate', 'translate_option_rel_create') => Yii::app()->createUrl('/economy/translateLanguageOption/create'),
        );
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['TranslateLanguageOptionRel'])) {
            $model->attributes = $_POST['TranslateLanguageOptionRel'];
            $model->site_id = $this->site_id;
            $model->created_time = time();
            if ($model->save()){
                $this->redirect(array('view', 'id' => $model->id));
            }else{
                $model->getErrors();
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
    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_option_rel_manager') => Yii::app()->createUrl('/economy/translateLanguageOption'),
            Yii::t('translate', 'translate_option_rel_update') => Yii::app()->createUrl('/economy/translateLanguageOption/update'),
        );
        //
        $model = $this->loadModel($id);

        if (isset($_POST['TranslateLanguageOptionRel'])) {
            $model->attributes = $_POST['TranslateLanguageOptionRel'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('/economy/translateLanguageOption'));
            }
        }

        $this->render('create', array(
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
        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_option_rel_manager') => Yii::app()->createUrl('translate'),
        );
        $model = new TranslateLanguageOptionRel('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;

        if (isset($_GET['TranslateLanguageOptionRel']))
            $model->attributes = $_GET['TranslateLanguageOptionRel'];

        $this->render('index', array(
            'model' => $model,
        ));
//
//        $dataProvider = new CActiveDataProvider('TranslateLanguageOptionRel');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TranslateLanguageOptionRel the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = TranslateLanguageOptionRel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TranslateLanguageOptionRel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'translate-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
                    $pro_id = $model->id;
                    if ($model->site_id == $this->site_id) {
                        if ($model->delete()) {
                            $translateLanguage = TranslateLanguageOptionRel::model()->findByPk($pro_id);
                            $translateLanguage->delete();
                        }
                    }
                }
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCopy($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('translate', 'translateLanguage_manager') => Yii::app()->createUrl('content/translateLanguageOption'),
            Yii::t('translate', 'translateLanguage_edit') => Yii::app()->createUrl('/content/translateLanguageOption/update', array('id' => $id)),
        );
        //
        $OldModel = $this->loadModel($id);

        $model = new TranslateLanguageOptionRel;
        $model->attributes = $OldModel->attributes;
        $model->id = '';
        $model->created_time = time();

        //
        if (isset($_POST['TranslateLanguageOptionRel'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();

            $model->attributes = $_POST['TranslateLanguageOptionRel'];
            if (isset($_POST['TranslateLanguageOptionRel']['store_ids']) && $_POST['TranslateLanguageOptionRel']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['TranslateLanguageOptionRel']['store_ids']);
            }
            if (!(int)$model->translateLanguage_category_id)
                $model->translateLanguage_category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int)strtotime($model->publicdate) > 0)
                $model->publicdate = (int)strtotime($model->publicdate);
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';
            // các danh mục cha của danh mục select lưu vào db
            $categoryTrack = array_reverse($category->saveTrack($model->translateLanguage_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/content/translateLanguageOption'));
            }
        }
        if (isset($_POST['TranslateLanguageOptionRel']['video_links']) || count($_POST['TranslateLanguageOptionRel']['video_links'])) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

}
