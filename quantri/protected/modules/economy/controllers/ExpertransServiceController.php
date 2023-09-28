<?php

class ExpertransServiceController extends BackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/expertransService'),
            Yii::t('translate', 'translate_create') => Yii::app()->createUrl('/economy/expertransService/create'),
        );
        //
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
        $model = new ExpertransService;

        $this->breadcrumbs = array(
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/expertransService'),
            Yii::t('translate', 'translate_create') => Yii::app()->createUrl('/economy/expertransService/create'),
        );
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ExpertransService'])) {
            $model->attributes = $_POST['ExpertransService'];
            $model->site_id = $this->site_id;
            $model->created_time = time();
            if ($model->save())
                $this->redirect(array('index'));
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
            Yii::t('translate', 'translate_manager') => Yii::app()->createUrl('/economy/expertransService'),
            Yii::t('translate', 'translate_update') => Yii::app()->createUrl('/economy/expertransService/update'),
        );
        //
        $model = $this->loadModel($id);

        if (isset($_POST['ExpertransService'])) {
            $model->attributes = $_POST['ExpertransService'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('/economy/expertransService'));
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
        $model = new ExpertransService('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;

        if (isset($_GET['ExpertransService']))
            $model->attributes = $_GET['ExpertransService'];

        $this->render('index', array(
            'model' => $model,
        ));
//
//        $dataProvider = new CActiveDataProvider('ExpertransService');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
    }

    /**
     * Lists all models.
     */
    public function actionOrderForm()
    {

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ExpertransService the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = new ExpertransService();
        $model->setTranslate(false);
        //
        $OldModel = $model->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $model->setTranslate(true);
            $model = $model->findByPk($id);
            if (!$model) {
                $model = new $model();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }

        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ExpertransService $model the model to be validated
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
                            $ExpertransService = ExpertransService::model()->findByPk($pro_id);
                            $ExpertransService->delete();
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
            Yii::t('translate', 'ExpertransService_manager') => Yii::app()->createUrl('content/ExpertransService'),
            Yii::t('translate', 'ExpertransService_edit') => Yii::app()->createUrl('/content/ExpertransService/update', array('id' => $id)),
        );
        //
        $OldModel = $this->loadModel($id);

        $model = new ExpertransService;
        $model->attributes = $OldModel->attributes;
        $model->id = '';
        $model->created_time = time();

        //
        if (isset($_POST['ExpertransService'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();

            $model->attributes = $_POST['ExpertransService'];
            if (isset($_POST['ExpertransService']['store_ids']) && $_POST['ExpertransService']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['ExpertransService']['store_ids']);
            }
            if (!(int)$model->ExpertransService_category_id)
                $model->ExpertransService_category_id = null;
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
            $categoryTrack = array_reverse($category->saveTrack($model->ExpertransService_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/content/ExpertransService'));
            }
        }
        if (isset($_POST['ExpertransService']['video_links']) || count($_POST['ExpertransService']['video_links'])) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }
    //
//'escort_negotiation_inter_price' => 'Escort negotiation Price',
//'consecutive_inter_price' => 'Consecutive Inter Price',
//'simultaneous_inter_price' => 'Simultaneous Inter Price',
    public function actionUpdateSimultaneous()
    {
        $id = (int)Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = ExpertransService::model()->findByPk($id);
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
                $model->consecutive_inter_price = $price;
                if ($model->save()) {
                    $this->jsonResponse(200);
                }
            }
        }
    }

    public function actionUpdateEscort()
    {
        $id = (int)Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = ExpertransService::model()->findByPk($id);
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
                $model->escort_negotiation_inter_price = $price;
                if ($model->save()) {
                    $this->jsonResponse(200);
                }
            }
        }
    }

    public function actionUpdateConsecutive()
    {
        $id = (int)Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = ExpertransService::model()->findByPk($id);
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
                $model->consecutive_inter_price = $price;
                if ($model->save()) {
                    $this->jsonResponse(200);
                }
            }
        }
    }

    public function actionUpdateaffilate() {
        $id = (int) Yii::app()->request->getParam('item_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = ExpertransService::model()->findByPk($id);
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

}
