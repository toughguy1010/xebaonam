<?php

class ProductAttributeSetController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('attribute_set', 'attribute_set_manager') => Yii::app()->createUrl('/economy/productAttributeSet'),
            Yii::t('attribute_set', 'attribute_set_create') => Yii::app()->createUrl('/economy/productAttributeSet/create'),
        );
        //
        $model = new ProductAttributeSet;
        $model->sort_order = (int) $model->getMaxSort() + 2;
        $model->site_id = $this->site_id;
        if (isset($_POST['ProductAttributeSet'])) {
            $model->attributes = $_POST['ProductAttributeSet'];
            $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
            if ($model->site_id !== $this->site_id)
                throw new CHttpException(403, "You don't have permission");
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Thêm mới thành công');
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/economy/productAttributeSet'),
                    ));
                } else {
                    $this->redirect(array('index'));
                }
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
            Yii::t('attribute_set', 'attribute_set_manager') => Yii::app()->createUrl('/economy/productAttributeSet'),
            Yii::t('attribute_set', 'attribute_set_edit') => Yii::app()->createUrl('/economy/productAttributeSet/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductAttributeSet'])) {
            $model->attributes = $_POST['ProductAttributeSet'];
            $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/economy/productAttributeSet'),
                    ));
                } else {
                    $this->redirect(array('index'));
                }
            } else
                var_dump($model->getErrors());
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
        $attributeSet = $this->loadModel($id);
        if ($attributeSet->site_id != $this->site_id)
            $this->jsonResponse(400);
        if ($attributeSet->validateDelete($id)) {
            if ($attributeSet->delete()) {
                Yii::app()->user->setFlash('success', 'Xóa nhóm thuộc tính thành công');
            }
        } else {
            Yii::app()->user->setFlash('error', 'Lỗi xóa nhóm thuộc tính! Vui lòng xóa hết thuộc tính trong nhóm này trước');
        }
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
                        if ($model->validateDelete($ids[$i])) {
                            $model->delete();
                        } else {
                            Yii::app()->user->setFlash('error', 'Lỗi xóa 1 số nhóm thuộc tính! Vui lòng xóa hết thuộc tính trong nhóm này trước');
                        }
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('attribute_set', 'attribute_set_manager') => Yii::app()->createUrl('/economy/productAttributeSet'),
        );
        //
        $model = new ProductAttributeSet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductAttributeSet']))
            $model->attributes = $_GET['ProductAttributeSet'];
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductAttributeSet the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $ProductAttributeSet = new ProductAttributeSet();
        $ProductAttributeSet->setTranslate(false);
        //
        $OldModel = $ProductAttributeSet->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $ProductAttributeSet->setTranslate(true);
            $model = $ProductAttributeSet->findByPk($id);
            if (!$model) {
                $model = new ProductAttributeSet();
                $model->id = $id;
                $model->site_id = $this->site_id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductAttributeSet $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-attribute-set-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
