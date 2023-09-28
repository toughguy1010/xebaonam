<?php

/**
 * @author công <cntt.vancong1993@gmodule.com>
 * @date 20/07/2021
 */
class ModulesController extends ApiController
{

    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('module', 'module_manager') => Yii::app()->createUrl('v3admin/modules'),
        );
        $model = new V3Modules('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['V3Modules'])) {
            $model->attributes = $_GET['V3Modules'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('module', 'module_manager') => Yii::app()->createUrl('v3admin/modules'),
            Yii::t('module', 'module_create') => Yii::app()->createUrl('/v3admin/modules/create'),
        );
        //
        $model = new V3Modules;
        if (isset($_POST['V3Modules'])) {
            $model->attributes = $_POST['V3Modules'];
            $model->setId($model->id_temp);
            if ($model->src) {
                $avatar = Yii::app()->session[$model->src];
                if (!$avatar) {
                    $model->src = '';
                } else {
                    $avatar = UploadLib::getSaveLink($avatar, 'module/');
                    $model->src = $avatar['baseUrl'] . $avatar['name'];
                }
            }
            if (!$model->hasErrors()) {
                $data = ClaWidget::loadConfigBackend($model->id);
                $data = isset($data['config']) ? $data['config'] : [];
                $model->setDataConfig($data);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'savesuccess'));
                    $this->redirect(array('index'));
                }
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
            Yii::t('module', 'module_manager') => Yii::app()->createUrl('v3admin/modules'),
            Yii::t('module', 'module_create') => Yii::app()->createUrl('/v3admin/modules/create'),
        );
        $model = $this->loadModel($id);
        if (isset($_POST['V3Modules'])) {
            $model->attributes = $_POST['V3Modules'];
            $model->id_temp = -1;
            if ($model->src) {
                $avatar = Yii::app()->session[$model->src];
                if ($avatar) {
                    $avatar = UploadLib::getSaveLink($avatar, 'module/');
                    $model->src = $avatar['baseUrl'] . $avatar['name'];
                }
            }
            if (!$model->hasErrors()) {
                $data = ClaWidget::loadConfigBackend($model->id);
                $data = isset($data['config']) ? $data['config'] : [];
                $model->setDataConfig($data);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
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
        $model = V3Modules::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'module-settings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
