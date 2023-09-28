<?php

class TranslateLanguageController extends BackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/translateLanguage'),
            Yii::t('translate', 'translate_create') => Yii::app()->createUrl('/economy/translateLanguage/create'),
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
        $model = new TranslateLanguage;

        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/translateLanguage'),
            Yii::t('translate', 'translate_create') => Yii::app()->createUrl('/economy/translateLanguage/create'),
        );
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->aff_percent = 10.00;
        if (isset($_POST['TranslateLanguage'])) {
            $model->attributes = $_POST['TranslateLanguage'];
            $model->site_id = $this->site_id;
            $model->created_time = time();

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/translateLanguage'),
            Yii::t('translate', 'translate_update') => Yii::app()->createUrl('/economy/translateLanguage/update'),
        );
        //
        $model = $this->loadModel($id);

        if (isset($_POST['TranslateLanguage'])) {
            $model->attributes = $_POST['TranslateLanguage'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('/economy/translateLanguage'));
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
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('translate'),
        );
        $model = new TranslateLanguage('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;

        if (isset($_GET['TranslateLanguage']))
            $model->attributes = $_GET['TranslateLanguage'];

        $this->render('index', array(
            'model' => $model,
        ));
//
//        $dataProvider = new CActiveDataProvider('TranslateLanguage');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TranslateLanguage the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = TranslateLanguage::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TranslateLanguage $model the model to be validated
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
                            $translateLanguage = TranslateLanguage::model()->findByPk($pro_id);
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
            Yii::t('translate', 'translateLanguage_manager') => Yii::app()->createUrl('content/translateLanguage'),
            Yii::t('translate', 'translateLanguage_edit') => Yii::app()->createUrl('/content/translateLanguage/update', array('id' => $id)),
        );
        //
        $OldModel = $this->loadModel($id);

        $model = new TranslateLanguage;
        $model->attributes = $OldModel->attributes;
        $model->id = '';
        $model->created_time = time();

        //
        if (isset($_POST['TranslateLanguage'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();

            $model->attributes = $_POST['TranslateLanguage'];
            if (isset($_POST['TranslateLanguage']['store_ids']) && $_POST['TranslateLanguage']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['TranslateLanguage']['store_ids']);
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
                $this->redirect(Yii::app()->createUrl('/content/translateLanguage'));
            }
        }
        if (isset($_POST['TranslateLanguage']['video_links']) || count($_POST['TranslateLanguage']['video_links'])) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateaffilate() {
        $id = (int) Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = TranslateLanguage::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $aff_percent = (float)Yii::app()->request->getParam('aff_percent');
            //
            if ($aff_percent) {
                $model->aff_percent = $aff_percent;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

    public function actionUpdatePriceBusiness()    {
        $id = (int)Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = TranslateLanguage::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $price_business = (float)Yii::app()->request->getParam('price');
            //
            if ($price_business) {
                $model->price_business = $price_business;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

    public function actionUpdatePriceStandard()
    {
        $id = (int)Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = TranslateLanguage::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $price = (float)Yii::app()->request->getParam('price');
            //
            if ($price) {
                $model->price = $price;
                if ($model->save()) {
                    $this->jsonResponse(200);
                }
            }
        }
    }


}
