<?php

class TourSeasonController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate()
    {
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_season_manager') => Yii::app()->createUrl('/tour/tourSeason'),
            Yii::t('tour', 'tour_season_create') => Yii::app()->createUrl('tour/tourSeason/create'),
        );
        //
        $model = new TourSeason();
        $post = Yii::app()->request->getPost('TourSeason');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/tour/tourSeason'));
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
        //
        $model = $this->loadModel($id);
        //
        $post = Yii::app()->request->getPost('TourSeason');
        if (isset($post)) {
            $model->attributes = $_POST['TourSeason'];
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/tour/tourSeason'));
        }
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_season_manager') => Yii::app()->createUrl('/tour/tourSeason'),
            Yii::t('tour', 'tour_season_update') => Yii::app()->createUrl('tour/tourSeason/update'),
        );
        //
        $this->render('addcat', array(
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
        $model = $this->loadModel($id);
        if ($model->site_id == $this->site_id) {
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->createUrl('/tour/tourSeason'));
    }

    /**
     * Xóa nhiều bản ghi
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
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_season_manager') => Yii::app()->createUrl('/tour/tourSeason'),
        );

        $model = new TourSeason();
        $model->site_id = $this->site_id;
        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MenuGroups the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        //
        $tourseason = new TourSeason();
        if (!$noTranslate) {
            $tourseason->setTranslate(false);
        }
        //
        $OldModel = $tourseason->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $tourseason->setTranslate(true);
            $model = $tourseason->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new TourSeason();
                $model->id = $id;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MenuGroups $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tour-season-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
