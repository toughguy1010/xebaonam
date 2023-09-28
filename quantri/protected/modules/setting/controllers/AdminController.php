<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 10/08/2018
 */
class AdminController extends BackController {

    public $layout = '//layouts/main';

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
        );
        //
        $sitesetting = new SitesAdmin();
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        if (!$model) {
            $this->sendResponse(404);
        }
        if (isset($_POST['SitesAdmin'])) {
            $post = $_POST['SitesAdmin'];
            if (!ClaUser::isNanoAdmin()) {
                if (isset($post['expiration_date'])) {
                    unset($post['expiration_date']);
                }
                if (isset($post['storage_limit'])) {
                    unset($post['storage_limit']);
                }
                if (isset($post['storage_used'])) {
                    unset($post['storage_used']);
                }
            }
            $model->attributes = $post;
            if (ClaUser::isSupperAdmin()) {
                //
                if ($model->expiration_date && $model->expiration_date != '' && (int) strtotime($model->expiration_date)) {
                    $model->expiration_date = (int) strtotime($model->expiration_date);
                }
                // validate languages_map
                $_languages_map = $model->languages_map;
                $languages_map = array();
                if ($_languages_map) {
                    $languages = ClaSite::getLanguageSupport();
                    foreach ($_languages_map as $languages_for_site) {
                        if (isset($languages[$languages_for_site])) {
                            $languages_map[$languages_for_site] = $languages_for_site;
                        }
                    }
                }
                if (count($languages_map)) {
                    $model->languages_map = implode(' ', $languages_map);
                } else {
                    $model->languages_map = '';
                }
                //
                if ($model->storage_limit) {
                    $model->storage_limit = ClaConvert::convertMBtoB($model->storage_limit);
                }
            }
            //
            if ($model->save()) {
                //
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        if (!$model->storage_limit) {
            $model->storage_limit = null;
        } else {
            $model->storage_limit = ClaConvert::convertBtoMB($model->storage_limit);
        }
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SitesAdmin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $SitesAdmin = new SitesAdmin();
        //
        $model = $SitesAdmin->findByPk($id);
        //
        return $model;
    }

    function beforeAction($action) {
        if(!ClaUser::isSupperAdmin()){
            return false;
        }
        return parent::beforeAction($action);
    }
    
}
