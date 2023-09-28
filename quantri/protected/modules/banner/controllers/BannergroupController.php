<?php

class BannergroupController extends BackController {

    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_group_manager') => Yii::app()->createUrl('banner/bannergroup'),
            Yii::t('banner', 'banner_group_create') => Yii::app()->createUrl('banner/bannergroup/create'),
        );
        //
        $model = new BannerGroups;
        if (isset($_POST['BannerGroups'])) {
            $model->attributes = $_POST['BannerGroups'];
            if (!$model->width && !$model->height)
                $model->addError('groupsize', 'require_with_or_height');

            if ($model->validate(null, false)) {
                if ($model->save(false))
                    $this->redirect(array('index'));
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
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_group_manager') => Yii::app()->createUrl('banner/bannergroup'),
            Yii::t('banner', 'banner_group_update') => Yii::app()->createUrl('banner/bannergroup/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['BannerGroups'])) {
            $model->attributes = $_POST['BannerGroups'];
            if (!$model->width && !$model->height)
                $model->addError('groupsize', Yii::t('errors', 'require_with_or_height'));
            if ($model->validate(null, false)) {
                if ($model->save(false))
                    $this->redirect(array('index'));
            }
        }
        if (!$model->width)
            $model->width = null;
        if (!$model->height)
            $model->height = null;
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
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Xóa nhiều bản ghi
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
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_group_manager') => Yii::app()->createUrl('banner/bannergroup'),
        );
        //
        $model = new BannerGroups('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['BannerGroups']))
            $model->attributes = $_GET['BannerGroups'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionList() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_group_manager') => Yii::app()->createUrl('banner/bannergroup'),
        );
        //
        $bgid = Yii::app()->request->getParam('bgid');
        if (!$bgid)
            $this->sendResponse(400);
        $bannergroup = BannerGroups::model()->findByPk($bgid);
        if (!$bannergroup)
            $this->sendResponse(404);
        if ($bannergroup->site_id != $this->site_id)
            $this->sendResponse(404);

        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $bannergroup->banner_group_name => Yii::app()->createUrl('banner/bannergroup/list', array('bgid' => $bgid)),
        ));
        $this->render('list', array(
            'banner_group_id' => $bgid,
            'bannergroup' => $bannergroup,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return BannerGroups the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $BannerGroups = new BannerGroups();
        $BannerGroups->setTranslate(false);
        //
        $OldModel = $BannerGroups->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $BannerGroups->setTranslate(true);
            $model = $BannerGroups->findByPk($id);
            if (!$model) {
                $model = new BannerGroups();
                $model->banner_group_id = $id;
                $model->width = $OldModel->width;
                $model->height = $OldModel->height;

            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param BannerGroups $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banner-groups-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
