<?php

/**
 * @author công <cntt.vancong1993@gsite.com>
 * @date 20/07/2021
 */
class SitesController extends ApiController
{

    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('site', 'site_manager') => Yii::app()->createUrl('v3admin/sites'),
        );
        $model = new V3SiteManagers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['V3SiteManagers'])) {
            $model->attributes = $_GET['V3SiteManagers'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionTest()
    {
        // $model = V3SiteManagers::model()->findByPk(1);
        // $model->loadDataDemo();
        FileMedia::emptyFoldel('images/nanoapp.vn');
        // CfgFile::xcopyc('v2.nanoweb.vn', 'nanoapp.vn');
        echo "oke";
    }

    public function actionClearData($site_id)
    {
        if ($this->site_id == 1) {
            $model = V3SiteManagers::model()->findByPk($site_id);
            $model->clearData();
        }
    }

    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('site', 'site_manager') => Yii::app()->createUrl('v3admin/sites'),
            Yii::t('site', 'site_create') => Yii::app()->createUrl('/v3admin/sites/create'),
        );
        //
        $model = new V3SiteManagers;
        if (isset($_POST['V3SiteManagers'])) {
            $model->attributes = $_POST['V3SiteManagers'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'savesuccess'));
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('site', 'site_manager') => Yii::app()->createUrl('v3admin/sites'),
            Yii::t('site', 'site_create') => Yii::app()->createUrl('/v3admin/sites/create'),
        );
        $model = $this->loadModel($id);
        if (isset($_POST['V3SiteManagers'])) {
            $model->attributes = $_POST['V3SiteManagers'];
            if ($model->avatar) {
                $model->getImageUpload($model->avatar, 'avatar_path', 'avatar_name');
            }
            if (!$model->hasErrors()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                    $this->redirect(array('update', 'id' => $model->id));
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if (Yii::app()->user->id != ClaUser::getSupperAdmin()) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function loadModel($id)
    {
        $model = V3SiteManagers::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
