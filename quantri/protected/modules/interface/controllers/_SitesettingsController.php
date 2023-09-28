<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/14/2014
 */
class SitesettingsController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * footer setting
     */
    public function actionFootersetting() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_footer') => Yii::app()->createUrl('/interface/sitesettings/footersetting'),
        );
        //
        $site_id = $this->site_id;
        $model = $this->loadSiteModel($site_id);
        $pagewidgetlist = Yii::app()->request->getParam('pagewidgetlist', 0);
        //
        if (isset($_POST['SiteSettings'])) {
            $settingpost = $_POST['SiteSettings'];
            $model->footercontent = $settingpost['footercontent'];
            if ($model->save()) {
                if ($pagewidgetlist) {
                    $url = Yii::app()->createUrl('widget/widget/pagewidgetlist');
                    $this->redirect($url);
                }
                Yii::app()->user->setFlash('success', Yii::t('status', 'update_success'));
            }
        }
        $this->render('footer', array('model' => $model));
    }

    public function actionStylecustom() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'stylecustom') => Yii::app()->createUrl('/interface/sitesettings/stylecustom'),
        );
        //
        $site_id = $this->site_id;
        $model = $this->loadSiteModel($site_id);
        //
        if (isset($_POST['SiteSettings'])) {
            $settingpost = $_POST['SiteSettings'];
            $model->stylecustom = trim(strip_tags($settingpost['stylecustom']));
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('status', 'update_success'));
            }
        }
        $this->render('stylecustom', array('model' => $model));
    }

    /**
     * footer setting
     */
    public function actionContact() {
        //breadcrumbs
        $this->breadcrumbs = array(
            //Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/sitesettings'),
            Yii::t('common', 'setting_contact') => Yii::app()->createUrl('/interface/sitesettings/contact'),
        );
        //
        $site_id = $this->site_id;
        $model = $this->loadSiteModel($site_id);
        $pagewidgetlist = Yii::app()->request->getParam('pagewidgetlist', 0);
        //
        if (isset($_POST['SiteSettings'])) {
            $settingpost = $_POST['SiteSettings'];
            $model->contact = $settingpost['contact'];
            if ($model->save()) {
                if ($pagewidgetlist) {
                    $url = Yii::app()->createUrl('widget/widget/pagewidgetlist');
                    $this->redirect($url);
                }
                Yii::app()->user->setFlash('success', Yii::t('status', 'update_success'));
            }else{
                if(ClaUser::isSupperAdmin()){
                    var_dump($model->getErrors());
                }
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteSettings the loaded model
     * @throws CHttpException
     */
    public function loadSiteModel($id) {
        //
        $SiteSettings = new SiteSettings();
        $SiteSettings->setTranslate(false);
        //
        $OldModel = $SiteSettings->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $SiteSettings->setTranslate(true);
            $model = $SiteSettings->findByPk($id);
            if (!$model) {
                $model = new SiteSettings();
                $model->attributes = $OldModel->attributes;
                $model->meta_keywords = '';
                $model->meta_description = '';
                $model->meta_title = '';
                $model->site_logo = '';
                $model->site_title = '';
                $model->contact = '';
                $model->footercontent = '';
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

}
