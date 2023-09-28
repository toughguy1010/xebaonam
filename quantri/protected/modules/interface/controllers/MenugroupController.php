<?php

class MenugroupController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('interface/menugroup'),
            Yii::t('menu', 'menu_create') => Yii::app()->createUrl('interface/menugroup/create'),
        );
        //
        $model = new MenuGroups;
        if (isset($_POST['MenuGroups'])) {
            $model->attributes = $_POST['MenuGroups'];
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/interface/menugroup'));
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
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['MenuGroups'])) {
            $model->attributes = $_POST['MenuGroups'];
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/interface/menugroup'));
        }
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('interface/menugroup'),
            Yii::t('menu', 'menu_group_update') => Yii::app()->createUrl('interface/menugroup/update', array('id' => $id)),
        );
        //
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
        if ($model->site_id == $this->site_id) {
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(Yii::app()->createUrl('/interface/menugroup'));
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
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('interface/menugroup'),
        );
        //
        $model = new MenuGroups('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['MenuGroups']))
            $model->attributes = $_GET['MenuGroups'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionList() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('interface/menugroup'),
        );
        //
        $mgid = Yii::app()->request->getParam('mgid');
        if (!$mgid)
            $this->sendResponse(400);
        $menugroup = MenuGroups::model()->findByPk($mgid);
        if (!$menugroup)
            $this->sendResponse(404);
        if ($menugroup->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $menugroup->menu_group_name => Yii::app()->createUrl('interface/menugroup/list', array('mgid' => $mgid)),
        ));
        $this->render('list', array(
            'menu_group_id' => $mgid,
            'menugroup' => $menugroup,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MenuGroups the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $menugroup = new MenuGroups();
        if (!$noTranslate) {
            $menugroup->setTranslate(false);
        }
        //
        $OldModel = $menugroup->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $menugroup->setTranslate(true);
            $model = $menugroup->findByPk($id);
             if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new MenuGroups();
                $model->menu_group_id = $id;
            }
        } else{
            $model = $OldModel;
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MenuGroups $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-groups-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
